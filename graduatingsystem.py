# Simple Student Grading System

# Define a function to calculate the average score
def calculate_average(scores):
    return sum(scores) / len(scores)

# Define a function to determine the grade based on the average score
def determine_grade(average):
    if average >= 90:
        return 'A'
    elif average >= 80:
        return 'B'
    elif average >= 70:
        return 'C'
    elif average >= 60:
        return 'D'
    else:
        return 'F'

# Define the main function
def main():
    print("Welcome to the Student Grading System")
    num_subjects = int(input("Enter the number of subjects: "))
    
    # Initialize an empty list to store scores
    scores = []
    
    # Loop to get scores for each subject
    for i in range(num_subjects):
        score = float(input(f"Enter score for subject {i + 1}: "))
        scores.append(score)
    
    # Calculate the average score
    average_score = calculate_average(scores)
    
    # Determine the grade
    grade = determine_grade(average_score)
    
    # Display the results
    print("\n--- Student Report ---")
    print("Scores:", scores)
    print("Average Score:", average_score)
    print("Grade:", grade)

# Run the main function
main()
