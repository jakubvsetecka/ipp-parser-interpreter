import sys
import io


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

def parse_stdin():
    for line in sys.stdin:
        print(f'You entered: {line.strip()}')

def main():
    set_encoding()
    parse_args()
    parse_stdin()


if __name__ == '__main__':
    main()