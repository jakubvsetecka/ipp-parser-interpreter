# Define variables for convenience
ZIP_FILE=xvsete00.zip
TEST_DIR=temp_test_dir
FILES_TO_ZIP=parse.py modules readme1.pdf
DOC_DIR=./doc
DOC_FILE=readme1

# Default target
all: zip test

# Target to zip the required files
zip:
	rm -rf modules/__pycache__
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
	./tests/tomovi-ipp-parser-testy/run.sh
	cd ./tests/supplementary-tests/parse && NO_EXIT=1 ./test.sh ./../../../parse.py

# Target to create a PDF from the LaTeX document
pdf:
	# Change directory to the document folder and compile the LaTeX document into a PDF
	cd $(DOC_DIR); pdflatex $(DOC_FILE).tex
	cd $(DOC_DIR); pdflatex $(DOC_FILE).tex
	cd $(DOC_DIR);rm -f ./*.aux ./*.log ./*.out
	# Move the generated PDF back to the current directory
	mv $(DOC_DIR)/$(DOC_FILE).pdf .

# Clean target to remove generated files
clean:
	rm -f $(ZIP_FILE)
	rm -rf $(TEST_DIR)
	rm -f $(PDF_FILE)

.PHONY: all zip is_it_ok test pdf clean
