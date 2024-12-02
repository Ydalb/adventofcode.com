# Part 01

```
=SUMPRODUCT(ABS(SORT(A:A)-SORT(B:B)))
```

# Part 02

```
=SUMPRODUCT(A:A * COUNTIF(SORT(B:B); SORT(A:A)))
```