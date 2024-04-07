#!/bin/bash

# Directory containing the tests
TESTS_DIR="./tests"
# Path to PHP executable
PHP="php"
# Path to the interpret.php script
INTERPRET_SCRIPT="./interpret.php"

# Check each file with the .src extension in the tests directory
for SRC_FILE in $(find "$TESTS_DIR" -type f -name "*.src"); do
    BASE_NAME=${SRC_FILE%.src}
    IN_FILE="${BASE_NAME}.in"
    OUT_FILE="${BASE_NAME}.out"
    RC_FILE="${BASE_NAME}.rc"
    YOUR_OUT="${BASE_NAME}.your_out"
    YOUR_RC="${BASE_NAME}.your_rc"

    # Run interpret.php script
    if [ -f "$IN_FILE" ]; then
        $PHP "$INTERPRET_SCRIPT" --source="$SRC_FILE" < "$IN_FILE" > "$YOUR_OUT"
    else
        $PHP "$INTERPRET_SCRIPT" --source="$SRC_FILE" > "$YOUR_OUT"
    fi

    # Capture the exit status
    echo $? > "$YOUR_RC"

    # Compare the exit status
    if diff "$RC_FILE" "$YOUR_RC" > /dev/null; then
        echo "Exit status matches for $BASE_NAME"
    else
        echo "Exit status does not match for $BASE_NAME"
    fi

    # If exit status is 0, compare the output
    if [ "$(cat "$YOUR_RC")" -eq 0 ]; then
        if diff "$OUT_FILE" "$YOUR_OUT" > /dev/null; then
            echo "Output matches for $BASE_NAME"
        else
            echo "Output does not match for $BASE_NAME"
        fi
    else
        echo "Skipping output comparison for $BASE_NAME due to non-zero exit status"
    fi
done
