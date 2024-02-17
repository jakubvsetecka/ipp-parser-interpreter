import sys
import io
import re
from parse_utils import InstructionParser
from xml_generator import XMLGenerator

# RegexGolf

def set_encoding():
    sys.stdin = io.TextIOWrapper(sys.stdin.buffer, encoding='utf-8')
    sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

def parse_args():
    if (len(sys.argv) == 1):
        return
    elif (len(sys.argv) == 2 and sys.argv[1] == '--help'):
        print("Help message: This script accepts only '--help' as a valid argument.")
        sys.exit(0)
    else:
        print("Invalid argument. Only '--help' is accepted.", file=sys.stderr)
        sys.exit(10)

def main():
    set_encoding()
    parse_args()
    
    code = sys.stdin.read()

    xml_generator = XMLGenerator()
    instruction_parser = InstructionParser(xml_generator)

    instruction_parser.parse_code(code)

    # Generate and print the XML representation
    print(xml_generator.generate_xml())


if __name__ == '__main__':
    main()