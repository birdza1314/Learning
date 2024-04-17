A = [[2,1],
     [5,-3]]

B = [[-2,4],
     [3,-2]]

C= [[0,0],
    [0,0]]


for i in range(len(B)):
    for j in range(len(B[0])):
        C[i][j] = B[j][i]
B = C

for i in range(len(A)):
    for j in range(len(A[0])):
        A[i][j] = A[i][j] * 2

for i in range(len(A)):
    for j in range(len(A[0])):
        C[i][j] = A[i][j] - B[i][j]

print("\nResult:")
for row in C:
    print(row)