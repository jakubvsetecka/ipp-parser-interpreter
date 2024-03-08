import sys
import io
from modules.parse_utils import InstructionParser
from modules.xml_generator import XMLGenerator

def set_encoding():
    sys.stdin = io.TextIOWrapper(sys.stdin.buffer, encoding='utf-8')
    sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

def parse_args():

    help_message = "Usage: python3.10 parse.py [--help]\n\n" \

    if (len(sys.argv) == 1):
        return
    elif (len(sys.argv) == 2 and sys.argv[1] == '--help'):
        print(help_message, file=sys.stderr)
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

    try:
        instruction_parser.parse_code(code)
    except Exception as e:
        print(e, file=sys.stderr)
        sys.exit(23)

    # Generate and print the XML representation
    print(xml_generator.generate_xml())


if __name__ == '__main__':
    main()