import xml.etree.ElementTree as ET
from xml.dom.minidom import parseString
from parse_utils import Argument, Instruction  # Ensure parse_utils.py is correctly located
import re

class XMLGenerator:
    def __init__(self):
        self.root = ET.Element("program", language="IPPcode24")
        self.instruction_count = 0
    
    def add_instruction(self, instruction):
        self.instruction_count += 1
        order = self.instruction_count

        # Create instruction element
        instr_elem = ET.SubElement(self.root, "instruction", order=str(order), opcode=instruction.opcode)
        
        # Add args elements
        for i, arg in enumerate(instruction.args, start=1):
            arg_elem = ET.SubElement(instr_elem, f"arg{i}", type=arg.subtype.lower())
            arg_elem.text = self._format_value(arg.value)
    
    def _format_value(self, value):  # Add 'self' parameter
        pattern = r'^(string@|int@|bool@|nil@)'
        return re.sub(pattern, '', value)  # Correctly apply the substitution
    
    def generate_xml(self):
        raw_xml = ET.tostring(self.root, 'utf-8')
        parsed_xml = parseString(raw_xml)
        return parsed_xml.toprettyxml(indent="  ")

    def get_instruction_count(self):
        return self.instruction_count
