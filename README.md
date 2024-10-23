# IPP Parser & Interpreter
A PHP/Python-based parser and interpreter for IPPcode24 (An educational programming language)

## Overview
This project consists of two main components:
1. **Parser** (Python-based)
   - Located in the `parser/` directory
   - Handles parsing and validation of IPPcode24
   - Generates XML representation of the code

2. **Interpreter** (PHP-based)
   - Located in the `ipp-core/` directory
   - Interprets the XML representation
   - Executes the IPPcode24 instructions
   - Built with robust error handling and extensible architecture

## Project Structure
```
ipp-parser-interpreter/
├── ipp-core/           # PHP Interpreter component
│   ├── core/           # Core framework classes
│   └── student/        # Implementation classes
└── parser/            # Python Parser component
    ├── modules/       # Parser modules
    └── doc/           # Documentation
```

## Key Features
- Modular architecture separating core framework from implementation
- Comprehensive exception handling system
- Support for various instruction types:
  - Arithmetic operations
  - Control flow
  - Memory management
  - String operations
  - I/O operations
  - Debug capabilities
- Frame-based memory management
- Stack-based operations

## Technical Details
### Parser
- Written in Python
- Modules:
  - `parse_utils.py`: Parsing utilities
  - `xml_generator.py`: XML output generation
  - `enums.py`: Enumeration definitions

### Interpreter
- Written in PHP 8.3
- Object-oriented design
- Key components:
  - Frame management system
  - Data stack implementation
  - Call stack handling
  - Instruction factory pattern
  - XML parsing capabilities

## Development Setup
1. **Prerequisites**
   - PHP 8.3 or higher
   - Python 3.x
   - Composer (included as composer.phar)

2. **Installation**
   ```bash
   # Install PHP dependencies
   php composer.phar install
   ```

3. **Development Tools**
   - PHPStan for static analysis
   - VS Code with PHP Intelephense recommended
   - Development container support available

## License
This project is licensed under the MIT License - see the LICENSE file for details.

## Credits
Core Framework by:
- Radim Kocman
- Zbynek Krivka

Implementation by:
- xvsete00

## Development Environment Options
1. **Development Container**
   - Recommended for consistent development environment
   - Includes all necessary tools and extensions

2. **Merlin Server**
   - Compatible with the student server environment
   - Use PHP 8.3 specifically

3. **Custom Setup**
   - Ensure compatibility with Merlin server
   - Match PHP 8.3 configuration

## Project Standards
- PSR-4 autoloading compliance
- Comprehensive static analysis (PHPStan level 9)
- MIT licensed for academic and personal use
