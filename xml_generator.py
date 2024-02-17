import xml.etree.ElementTree as ET
from xml.dom.minidom import parseString

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
        return
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