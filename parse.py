import sys

# RegexGolf

def parse_args():
    if (len(sys.argv) == 1):
        return
    elif (len(sys.argv) == 2 and sys.argv[1] == '--help'):
        print("Help message: This script accepts only '--help' as a valid argument.")
    else:
        print("Invalid argument. Only '--help' is accepted.", file=sys.stderr)
        sys.exit(10)

def main():
    parse_args()


if __name__ == '__main__':
    main()
