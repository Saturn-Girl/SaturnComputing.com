    .data
result: .word 9        // reserve a 32-bit word, initial value 9

    .text
    .global _startup
    .global _halt

_startup:
    MOV X1, #4          // load 4 into X1
    MOV X2, #5          // load 5 into X2
    ADD X3, X1, X2      // X3 = 4 + 5 = 9

    LDR X9, =result     // X9 = address of 'result'
    STR W3, [X9]        // store 32-bit value of X3 into memory (result = 9)

    B _halt             // jump to halt loop

_halt:
    WFI                 // wait for interrupt (low power)
    B _halt             // infinite loop
