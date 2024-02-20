import re
import sys
from enums import InstructionFormat


#================================================================================================

class Argument:
    def __init__(self, type, value, subtype=None):
        self.type = type
        self.value = value
        self.subtype = subtype  # New attribute to store the specific subtype

    def __str__(self):
        return f"Argument(Type: {self.type}, Value: {self.value}, Subtype: {self.subtype})"

#================================================================================================

class Instruction:
    def __init__(self, opcode, args):
        self.opcode = opcode
        self.args = args  # List of Argument objects

    def __str__(self):
        # Returns a readable string representation of an Instruction object
        args_str = ', '.join(str(arg) for arg in self.args)
        return f"Instruction(Opcode: {self.opcode}, Args: [{args_str}])"

    def to_xml_element(self, xml_generator):
        # Convert this instruction to an XML element and attach it to the root
        return xml_generator.add_instruction(self)

#================================================================================================

class ArgumentParser:
    @staticmethod
    def parse(arg, expected_type_enum):
        # Use expected_type_enum to retrieve the regex pattern for validation
        pattern = re.compile(expected_type_enum.value, re.VERBOSE)
        match = pattern.match(arg)  # Correctly call the match method with arg
        found_arg = None
        if match:
            # Find which group was matched
            for subtype, value in match.groupdict().items():
                if value is not None:
                    # Return the first matched subtype with its value
                    if found_arg is None:
                        found_arg = Argument(expected_type_enum.name, value, subtype)
                    else:
                        raise ValueError(f"Argument {arg} matches multiple types")
        # Handle the case where no match is found
        if found_arg is None:
            raise ValueError(f"Argument {arg} does not match the expected type {expected_type_enum.name}")
       
        return found_arg  # Or raise an error, depending on your error handling strategy

#================================================================================================

class InstructionParser:
    def __init__(self, xml_generator):
        self.xml_generator = xml_generator

    def parse_line(self, line):
        # Break down the line into opcode and args
        # Validate opcode and argument count
        # Use ArgumentParser to parse each argument
        # Create an Instruction object and add it to the XML generator
        parts = line.split()
        opcode = parts[0].upper()
        args = parts[1:]
        
        # Retrieve the expected argument types for this instruction
        try:
            expected_arg_types = InstructionFormat[opcode].value
        except KeyError:
            sys.exit(32)
        
        # Parse each argument according to its expected type
        parsed_args = []
        for arg, expected_type in zip(args, expected_arg_types):
            parsed_arg = ArgumentParser.parse(arg, expected_type)
            parsed_args.append(parsed_arg)
        
        # Create an Instruction object and convert it to XML
        instruction = Instruction(opcode, parsed_args)
        print(instruction)
        print("\n")
        instruction.to_xml_element(self.xml_generator)
        pass

    def clean_code(self, code):
        # Remove comments and empty lines
        def remove_header(code):
            new_string, number_of_subs_made = re.subn(r'^\.[iI][pP][pP][cC][oO][dD][eE]24\s*\n', '', code)
            if number_of_subs_made == 1:
                return new_string
            else:
                sys.exit(21)

        def remove_comments(code):
            return re.sub(r'#.*', '', code)

        def remove_empty_lines(code):
            # Remove lines that consist only of whitespace
            cleaned_code = re.sub(r'(?m)^\s*\n', '', code)
            # Remove trailing whitespace at the end of the string, if present, without removing the final newline
            cleaned_code = re.sub(r'\n\s*$', '\n', cleaned_code)
            return cleaned_code
        
        code = remove_comments(code)
        code = remove_empty_lines(code)
        code = remove_header(code)
        
        return code

    def parse_code(self, code):
        # Main entry point for parsing code
        # Iterate through lines and parse each instruction
        code = self.clean_code(code)

        lines = code.strip().split("\n")
        for line in lines:
            self.parse_line(line.strip())

        pass
