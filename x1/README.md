# AI Agent Tools for Research Team Search

This project implements a system of tools for an AI agent to find information about research teams at Polish universities. Specifically, it's designed to find information about time travel research teams.

## Project Structure

```
.
├── README.md
├── tool1.php        # Tool for searching research projects
├── tool2.php        # Tool for finding team members
├── prompt.txt       # Agent prompt definition
├── test.php        # Test script for tools
├── badania.json    # Research projects data
├── osoby.json      # People/researchers data
└── uczelnie.json   # Universities data
```

## Tools Description

### Tool 1: Research Project Search
- Endpoint: `tool1.php`
- Purpose: Searches for research projects related to time travel
- Input: JSON with "input" field
- Output: JSON with "output" field containing array of matching projects
- Each project includes:
  - nazwa (name)
  - uczelnia (university code)
  - sponsor

### Tool 2: Team Member Search
- Endpoint: `tool2.php`
- Purpose: Finds team members at a specific university
- Input: JSON with "input" field containing university name
- Output: JSON with "output" field containing array of team members
- Each member includes:
  - imie (first name)
  - nazwisko (last name)
  - wiek (age)
  - plec (gender)

## Testing

Use the test script to verify tool functionality:

```bash
# Start PHP development server
php -S localhost:8000

# Run tests
php test.php
```

## Agent Workflow

1. Agent receives initial prompt from `prompt.txt`
2. Uses tool1 to find time travel research project
3. Uses tool2 to get team members at the identified university
4. Returns final answer with:
   - University name
   - Research sponsor
   - Team member list

## Limitations

- Maximum 5 steps per workflow (1 start + 3 tool uses + 1 answer)
- Maximum response length: 1024 characters
- Maximum webhook response time: 60 seconds
- Test requests must echo back the input string

## Test Request Format

Tools must handle test requests in this format:
```json
{
    "input": "test123"
}
```

Expected response:
```json
{
    "output": "test123"
}
```

## Regular Request Format

Example tool1 request:
```json
{
    "input": ""
}
```

Example tool2 request:
```json
{
    "input": "Uniwersytet Jagielloński"
}
```

## Requirements

- PHP with JSON extension
- PHP cURL extension
- Web server (Apache/Nginx) or PHP built-in server
- Read access to JSON data files 