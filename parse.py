import sys
import io
import re
from parse_utils import CodeParser

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

def parse_line(text, *group_types):
    # Define patterns for each group type
    patterns = {
        'var': r'(\$\w+)',  # Example: $variableName
        'symb': r'(\d+|\$\w+|\w+)',  # Example: 123, $variable, or symbolName
        'label': r'(@\w+)',  # Example: @labelName
        'type': r'(@\w+)',  # Example: @labelName
    }
    
    # Construct the regex pattern based on the specified group types
    regex_parts = [patterns[group_type] for group_type in group_types if group_type in patterns]
    pattern = '-'.join(regex_parts)
    
    # Search for the pattern in the text
    match = re.search(pattern, text)
    if match:
        return match.groups()  # Returns a tuple of all captured groups
    else:
        return None

def parse_stdin():
    for line in sys.stdin:
        linestr = line.strip()
        pattern = r'^(\w+)'
        instruction = re.match(pattern, linestr)
        instruction = instruction.group(1) if instruction else "No match"
        
        #TODO instructctions are case insensitive

        """match instruction:
            case "No match":
                print("No match")
            case "MOVE":
            case "CREATEFRAME":
            case "PUSHFRAME":
            case "POPFRAME":
            case "DEFVAR":
            case "CALL":
            case "RETURN":
            case "PUSHS":
            case "POPS":
            case "ADD":
            case "SUB":
            case "MUL":
            case "IDIV":
            case "LT":
            case "GT":
            case "EQ":
            case "AND":
            case "OR":
            case "NOT":
            case "INT2CHAR":
            case "STRI2INT":
            case "READ":
            case "WRITE":
            case "CONCAT":
            case "STRLEN":
            case "GETCHAR":
            case "SETCHAR":
            case "TYPE":
            case "LABEL":
            case "JUMP":
            case "JUMPIFEQ":
            case "JUMPIFNEQ":
            case "EXIT":"""

def main():
    set_encoding()
    parse_args()
    
    code = sys.stdin.read()

    parser = CodeParser()
    parser.parse_code(code)
    print(parser.get_xml())


if __name__ == '__main__':
    main()