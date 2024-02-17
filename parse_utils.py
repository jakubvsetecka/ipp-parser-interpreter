import xml.etree.ElementTree as ET
import re
import sys
from xml.dom.minidom import parseString
from enum import Enum

"""
The XMLGenerator class is a simple class that allows you to add instructions to an XML tree, and then generate the XML from that tree.
"""
class XMLGenerator:
    def __init__(self):
        self.root = ET.Element("program", language="IPPcode24")
        self.instruction_count = 0  # Initialize instruction counter
    
    def add_instruction(self, opcode, *args):
        return #TODO
        self.instruction_count += 1  # Increment instruction counter
        order = self.instruction_count
        instruction = ET.SubElement(self.root, "instruction", order=str(order), opcode=opcode.upper())
        for i, (arg_type, arg_value) in enumerate(args, start=1):
            arg_elem = ET.SubElement(instruction, f"arg{i}", type=arg_type)
            arg_elem.text = self._format_value(arg_type, arg_value)
    
    def _format_value(self, arg_type, arg_value):
        if arg_type == ArgumentInInst.VAR.value:
            return arg_value.upper()  # Memory frame in uppercase
        elif arg_type == "string":
            return arg_value.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")
        # Add more formatting rules as needed
        return arg_value
    
    def generate_xml(self):
        raw_xml = ET.tostring(self.root, 'utf-8')
        parsed_xml = parseString(raw_xml)
        return parsed_xml.toprettyxml(indent="  ")

    def get_instruction_count(self):
        return self.instruction_count

class ArgumentType(Enum):
    INT = r'\d+'
    BOOL = r'(true|false)'
    STRING = r'[^#\s]+'
    NIL = r'nil@nil'
    LABEL = r'(\w+)'
    VAR = r'(GF|TF|LF)@(\w+)'

class ArgumentInInst(Enum):
    VAR = ArgumentType.VAR.value
    SYMB = "|".join([
        ArgumentType.INT.value,
        ArgumentType.BOOL.value,
        ArgumentType.STRING.value,
        ArgumentType.NIL.value
    ])
    LABEL = ArgumentType.LABEL.value
    TYPE = "|".join([
        ArgumentType.STRING.value,
        ArgumentType.NIL.value,
        ArgumentType.BOOL.value,
        ArgumentType.INT.value
    ])

class Instruction(Enum):
    MOVE = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value]
    CREATEFRAME = []
    PUSHFRAME = []
    POPFRAME = []
    DEFVAR = [ArgumentInInst.VAR.value]
    CALL = [ArgumentInInst.LABEL.value]
    RETURN = []
    PUSHS = [ArgumentInInst.SYMB.value]
    POPS = [ArgumentInInst.VAR.value]
    ADD = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    SUB = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    MUL = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    IDIV = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    LT = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    GT = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    EQ = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    AND = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    OR = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    NOT = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value]
    INT2CHAR = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value]
    STRI2INT = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    READ = [ArgumentInInst.VAR.value, ArgumentInInst.TYPE.value]
    WRITE = [ArgumentInInst.SYMB.value]
    CONCAT = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    STRLEN = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value]
    GETCHAR = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    SETCHAR = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    TYPE = [ArgumentInInst.VAR.value, ArgumentInInst.SYMB.value]
    LABEL = [ArgumentInInst.LABEL.value]
    JUMP = [ArgumentInInst.LABEL.value]
    JUMPIFEQ = [ArgumentInInst.LABEL.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    JUMPIFNEQ = [ArgumentInInst.LABEL.value, ArgumentInInst.SYMB.value, ArgumentInInst.SYMB.value]
    EXIT = [ArgumentInInst.SYMB.value]


"""
The CodeParser class is a simple class that allows you to parse a list of instructions and generate an XML representation of those instructions.
"""
class CodeParser:
    def __init__(self):
        self.xml_generator = XMLGenerator()
        
    def parse_argument(self, arg, type):
        print(arg, type)
        matches = [match.group(0) for match in re.finditer(type, arg)]
        print(matches)
        if len(matches) != 1: #TODO
            sys.exit(21)
        return matches[0]

    def parse_arguments(self, types, args):
        return [self.parse_argument(args[i], types[i]) for i in range(len(types))]

    def parse_line(self, line):
        # Example parsing logic - you would replace this with actual parsing code
        parts = line.split()
        print(parts)
        opcode = parts[0]

        types = Instruction[opcode].value
        print(types)
        if len(parts) - 1 != len(types):
            print(f"Invalid number of arguments for instruction {opcode}")
            print(f"Expected {len(types)} arguments, got {len(parts) - 1}")
            print(types, parts)
            sys.exit(21)

        args = self.parse_arguments(types, parts[1:])
        print(f"\033[34m{args}\033[0m")
        self.xml_generator.add_instruction(opcode, *args)

    def remove_header(self, code):
        new_string, number_of_subs_made = re.subn(r'^\.IPPcode24\n', '', code)
        if number_of_subs_made == 1:
            return new_string
        else:
            sys.exit(21)

    def remove_comments(self, code):
        return re.sub(r'#.*', '', code)
    
    def remove_empty_lines(self, code):
        # Remove lines that consist only of whitespace
        cleaned_code = re.sub(r'(?m)^\s*\n', '', code)
        # Remove trailing whitespace at the end of the string, if present, without removing the final newline
        cleaned_code = re.sub(r'\n\s*$', '\n', cleaned_code)
        return cleaned_code
        
    def parse_code(self, code):
        code = self.remove_comments(code)
        code = self.remove_empty_lines(code)
        code = self.remove_header(code)
        print(code)
        lines = code.strip().split("\n")
        for line in lines:
            self.parse_line(line.strip())
            
    def get_xml(self):
        return self.xml_generator.generate_xml()