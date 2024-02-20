# Define variables for convenience
ZIP_FILE=xvsete00.zip
TEST_DIR=temp_test_dir
FILES_TO_ZIP=parse.py modules readme1.md

# Default target
all: zip test

# Target to zip the required files
zip:
	zip -r $(ZIP_FILE) $(FILES_TO_ZIP)

# Target to test the zip file using is_it_ok.sh
is_it_ok: zip
	# Ensure the test directory does not exist before starting
	rm -rf $(TEST_DIR)
	# Create a new test directory
	mkdir $(TEST_DIR)
	# Run the is_it_ok.sh script with the newly created zip file and the test directory
	yes | ./is_it_ok.sh $(ZIP_FILE) $(TEST_DIR)
	# Clean up the test directory after testing
	rm -rf $(TEST_DIR)
	rm -rf is_it_ok.log

# Target to run supplementary tests
test:
	cd ./supplementary-tests/parse && ./test.sh ./../../parse.py

# Clean target to remove generated files
clean:
	rm -f $(ZIP_FILE)
	rm -rf $(TEST_DIR)

.PHONY: all zip is_it_ok test clean
