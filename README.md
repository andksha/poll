## Poll

Backend application for creating and filling Polls.

## APIs
Each Poll (id, name) has Questions(id, pollID, parentID, name) that have Answers (id, questionID, content).
Questions also can have subordinate Questions.

There is POST /poll API in for creating polls in Admin\PollController and POST, PUT, DELETE 
question APIs in Admin\QuestionController for creating, updating and deleting questions and their answers.

There is also POST /poll API in PollController for filling polls with answers.

## Architecture

Each API has corresponding FormRequest, DTO object, that is returned from FormRequest and
UseCase object, that encapsulates logic of each process (e.g. creating poll, updating questions
etc.). JSONResources and JSONCollections are used to define format of responses.