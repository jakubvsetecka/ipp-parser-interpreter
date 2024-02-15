import re

def parse_line(text, *group_types):
    # Define patterns for each group type
    patterns = {
        'var': r'(\$\w+)',  # Example: $variableName
        'symb': r'(\d+|\$\w+|\w+)',  # Example: 123, $variable, or symbolName
        'label': r'(@\w+)',  # Example: @labelName
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

# Example usage
text = "@labelName-$variableName-123"
print(parse_line(text, 'label', 'var', 'symb'))  # Example: Matching label, var, and symb

text = "$variableName-456"
print(parse_line(text, 'var', 'symb'))  # Example: Matching var and symb

text = "123-@labelName"
print(parse_line(text, 'symb', 'label'))  # Example: Matching symb and label
