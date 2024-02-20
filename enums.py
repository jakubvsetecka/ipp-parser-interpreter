from enum import Enum

class ArgumentType(Enum):
    INT = r'(?:int@)(?P<INT>\d+)'
    BOOL = r'^(?:bool@)(?P<BOOL>true|false)'
    STRING = r'^(?:string@)(?P<STRING>[^#\s\\]*)'
    TYPE = r'(?P<TYPE>string|bool|int)'
    NIL = r'^(nil@)(?P<NIL>nil)'
    LABEL = r'(?P<LABEL>\w+)'
    VAR = r'(?P<VAR>(GF|TF|LF)@\w+)'

class ArgumentInInst(Enum):
    VAR = ArgumentType.VAR.value
    SYMB = "|".join([
        ArgumentType.VAR.value,
        ArgumentType.INT.value,
        ArgumentType.BOOL.value,
        ArgumentType.STRING.value,
        ArgumentType.NIL.value
    ])
    LABEL = ArgumentType.LABEL.value
    TYPE = ArgumentType.TYPE.value

class InstructionFormat(Enum):
    MOVE = [ArgumentInInst.VAR, ArgumentInInst.SYMB]
    CREATEFRAME = []
    PUSHFRAME = []
    POPFRAME = []
    DEFVAR = [ArgumentInInst.VAR]
    CALL = [ArgumentInInst.LABEL]
    RETURN = []
    PUSHS = [ArgumentInInst.SYMB]
    POPS = [ArgumentInInst.VAR]
    ADD = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    SUB = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    MUL = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    IDIV = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    LT = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    GT = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    EQ = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    AND = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    OR = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    NOT = [ArgumentInInst.VAR, ArgumentInInst.SYMB]
    INT2CHAR = [ArgumentInInst.VAR, ArgumentInInst.SYMB]
    STRI2INT = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    READ = [ArgumentInInst.VAR, ArgumentInInst.TYPE]
    WRITE = [ArgumentInInst.SYMB]
    CONCAT = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    STRLEN = [ArgumentInInst.VAR, ArgumentInInst.SYMB]
    GETCHAR = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    SETCHAR = [ArgumentInInst.VAR, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    TYPE = [ArgumentInInst.VAR, ArgumentInInst.SYMB]
    LABEL = [ArgumentInInst.LABEL]
    JUMP = [ArgumentInInst.LABEL]
    JUMPIFEQ = [ArgumentInInst.LABEL, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    JUMPIFNEQ = [ArgumentInInst.LABEL, ArgumentInInst.SYMB, ArgumentInInst.SYMB]
    EXIT = [ArgumentInInst.SYMB]