/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/UnitTests/JUnit5TestClass.java to edit this template
 */
package com.mycompany.tienda_videojuegos;

import java.util.Arrays;
import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.AfterAll;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

/**
 *
 * @author andre
 */
public class VentanaHorarioTest {
    
    public VentanaHorarioTest() {
    }
    
    @BeforeAll
    public static void setUpClass() {
    }
    
    @AfterAll
    public static void tearDownClass() {
    }
    
    @BeforeEach
    public void setUp() {
    }
    
    @AfterEach
    public void tearDown() {
    }

    /**
     * Test para comprobar si se reciben bien los datos.
     */
    @Test
    public void testMain() {
        System.out.println("main");
        VentanaHorario horario = new VentanaHorario(2);
        String[] expResult = {"Lunes","Martes","Miércoles","Sábado","Domingo"};
        String[] result = horario.obtenerDiasSemana(2);
        
        assertEquals(expResult, result);
    }    
}
