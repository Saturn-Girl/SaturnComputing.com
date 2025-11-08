import sys

print("SATURN COMPUTING CALCULATORWARE V1")

while True:
    sys.stdout.write(">> ")
    equation = sys.stdin.readline().strip()
    try:
        result = eval(equation)
        print(result)
        with open("calculations.math", "a") as f:
            f.write(f"{equation} = {result}\n")
    except Exception as e:
        print(e)
