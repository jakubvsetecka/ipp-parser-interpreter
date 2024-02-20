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
            arg_elem.text = arg.value
    
    def generate_xml(self):
        # Generate a bytes object containing the XML with the specified encoding and XML declaration
        raw_xml = ET.tostring(self.root, encoding='utf-8', xml_declaration=True)
        
        # Convert bytes to string for parseString
        raw_xml_str = raw_xml.decode('utf-8')
        
        # Use minidom to prettify the XML
        parsed_xml = parseString(raw_xml_str)
        
        # Return the pretty-printed XML as a string, specifying the encoding explicitly in toprettyxml if needed
        return parsed_xml.toprettyxml(indent="  ", encoding="UTF-8").decode('utf-8')