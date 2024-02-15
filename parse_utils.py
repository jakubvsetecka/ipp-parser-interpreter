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
        self.instruction_count += 1  # Increment instruction counter
        order = self.instruction_count
        instruction = ET.SubElement(self.root, "instruction", order=str(order), opcode=opcode.upper())
        for i, (arg_type, arg_value) in enumerate(args, start=1):
            arg_elem = ET.SubElement(instruction, f"arg{i}", type=arg_type)
            arg_elem.text = self._format_value(arg_type, arg_value)
    
    def _format_value(self, arg_type, arg_value):
        if arg_type == "var":
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

class Instruction(Enum):
    MOVE = ["var", "symb"],
    CREATEFRAME = [],
    PUSHFRAME = [],
    POPFRAME = [],
    DEFVAR = ["var"],
    CALL = ["label"],
    RETURN = [],
    PUSHS = ["symb"],
    POPS = ["var"],
    ADD = ["var", "symb", "symb"],
    SUB = ["var", "symb", "symb"],
    MUL = ["var", "symb", "symb"],
    IDIV = ["var", "symb", "symb"],
    LT = ["var", "symb", "symb"],
    GT = ["var", "symb", "symb"],
    EQ = ["var", "symb", "symb"],
    AND = ["var", "symb", "symb"],
    OR = ["var", "symb", "symb"],
    NOT = ["var", "symb"],
    INT2CHAR = ["var", "symb"],
    STRI2INT = ["var", "symb", "symb"],
    READ = ["var", "type"],
    WRITE = ["symb"],
    CONCAT = ["var", "symb", "symb"],
    STRLEN = ["var", "symb"],
    GETCHAR = ["var", "symb", "symb"],
    SETCHAR = ["var", "symb", "symb"],
    TYPE = ["var", "symb"],
    LABEL = ["label"],
    JUMP = ["label"],
    JUMPIFEQ = ["label", "symb", "symb"],
    JUMPIFNEQ = ["label", "symb", "symb"],
    EXIT = ["symb"]


"""
The CodeParser class is a simple class that allows you to parse a list of instructions and generate an XML representation of those instructions.
"""
class CodeParser:
    def __init__(self):
        self.xml_generator = XMLGenerator()
        
    def parse_argument(self, arg, type):
        match type:
            case "var":
                return arg
            case "symb":
                return arg
            case "label":
                return arg
            case "type":
                return arg
        pass

    def parse_arguments(self, args, types):
        for arg, type in zip(args, types):
            yield self.parse_argument(arg, type)
            

    def parse_line(self, line):
        # Example parsing logic - you would replace this with actual parsing code
        parts = line.split()
        print(parts)
        opcode = parts[0]
        types = Instruction[opcode].value

        if len(parts) - 1 != len(types):
            sys.exit(21)

        args = self.parse_arguments(parts[1:], types)
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
        return re.sub(r'(?m)^\s*\n|\n\s*$', '', code)
        
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