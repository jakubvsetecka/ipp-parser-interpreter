import xml.etree.ElementTree as ET
import xml.dom.minidom
import sys

# Create your XML tree using ElementTree
root = ET.Element("root")
root.set("language", "IPPcode24")
child = ET.SubElement(root, "instruction")
child.set("order", "1")
child.set("opcode", "MOVE")
child = ET.SubElement(child, "arg1")
child.set("type", "int")
child.text = "32"

# Convert the ElementTree to a string
xml_str = ET.tostring(root, encoding='utf-8', method='xml')

# Use minidom to pretty print
dom = xml.dom.minidom.parseString(xml_str)
pretty_xml_as_string = dom.toprettyxml(indent="  ", encoding="UTF-8").decode('utf-8')

# Print the pretty-printed XML with the declaration to stdout
print(pretty_xml_as_string, file=sys.stdout)