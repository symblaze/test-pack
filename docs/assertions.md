# Assertions

## Database Assertions (ODM)

Database asserts are available through the `KernelTestTrait` trait.

| Method                    | Description                                             |
|---------------------------|---------------------------------------------------------|
| `assertDocumentExists`    | Asserts that a document exists in the database.         |
| `assertDocumentNotExists` | Asserts that a document does not exist in the database. |
| `assertDocumentCount`     | Asserts the number of documents in the database.        |

## Database Assertions (ORM)

Database asserts are available through the `KernelTestTrait` trait.

| Method                  | Description                                            |
|-------------------------|--------------------------------------------------------|
| `assertEntityExists`    | Asserts that an entity exists in the database.         |
| `assertEntityNotExists` | Asserts that an entity does not exist in the database. |

## Console Assertions

Console asserts are available through the `WithCommandTester` trait.

| Method                         | Description                                                  |
|--------------------------------|--------------------------------------------------------------|
| `assertCommandSucceeded()`     | Asserts that the command succeeded. Exit code = 0            |
| `assertCommandFailed()`        | Asserts that the command failed. Exit code = 1               |
| `assertCommandInvalid()`       | Asserts that the command failed. Exit code = 2               |
| `assertCommandDidNotSucceed()` | Asserts that the command did not succeed. Exit code is not 0 |
| `assertCommandOutputs()`       | Asserts that the command output contains a string            |
| `assertCommandNotOutputs()`    | Asserts that the command output does not contain a string    |
