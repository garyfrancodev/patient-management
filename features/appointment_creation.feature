Feature: Appointment Creation
    In order to schedule an appointment
    As an API client
    I need to send a valid POST request to /api/v1/appointment

    Scenario: Create an appointment with valid data
        Given I have a valid appointment payload:
            | nutritionist_id | 12345                                                |
            | patient_id      | 86537690-1680-47ca-8ca6-942bf3233d83                   |
            | reason          | catering                                             |
        When I send a POST request to "/api/v1/appointment"
        Then the response status code should be 200

    Scenario: Create an appointment with missing data
        Given I have an invalid appointment payload:
            | nutritionist_id |                                                      |
            | patient_id      |                                                      |
            | reason          |                                                      |
        When I send a POST request to "/api/v1/appointment"
        Then the response status code should be 200
