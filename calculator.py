def calculate_age():
    """
    Calculates a person's age based on their birth year.
    
    Prompts the user to enter their birth year, calculates the age,
    and prints the result.
    """
    # Get the current year
    current_year = 2024
    
    # Prompt the user to enter their birth year
    birth_year = int(input("Enter your birth year: "))
    
    # Calculate the age
    age = current_year - birth_year
    
    # Print the result
    print(f"You are {age} years old.")

# Call the function to start the program
calculate_age()