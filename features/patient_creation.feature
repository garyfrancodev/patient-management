Feature: Patient Creation
    In order to create a new patient record
    As an API client
    I need to send a valid POST request to /api/v1/patient

    Scenario: Create a patient with valid data
        Given I have a valid patient payload:
            | user_id   | 123456                                                |
            | full_name | {"first_name": "John", "last_name": "Doe"}           |
            | email     | john.doe@example.com                                  |
            | dni       | A123456789                                            |
            | phone     | 123456789                                             |
            | dob       | 2000-05-15                                            |
            | gender    | male                                                  |
        When I send a POST request to "/api/v1/patient"
        Then the response status code should be 200

    Scenario: Create a patient with invalid data
        Given I have an invalid patient payload:
            | user_id   |                                                      |
            | full_name | {"first_name": "John", "last_name": ""}              |
            | email     | notanemail                                           |
            | dni       |                                                      |
            | phone     |                                                      |
            | dob       | invalid-date                                         |
            | gender    | unknown                                              |
        When I send a POST request to "/api/v1/patient"
        Then the response status code should be 200
