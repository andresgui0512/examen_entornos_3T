/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/UnitTests/JUnit5TestClass.java to edit this template
 */
package com.mycompany.tienda_videojuegos;

import java.time.LocalDate;
import java.time.LocalTime;
import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.AfterAll;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

/**
 *
 * @author Andrés Guillén
 */
public class CheckinTest {
    
    public CheckinTest() {
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
     * Test para comprobar si se obtiene la fecha de forma correcta 
     * de la base de datos
     */
    @Test
    public void testObtenerFechaDeEntrada() {
        System.out.println("obtenerFechaDeEntrada");
        Checkin instance = new Checkin(3);
        LocalDate expResult = LocalDate.parse("2024-05-13");
        LocalDate result = instance.obtenerFechaDeEntrada();
        
        System.out.println("expResult: "+expResult);
        System.out.println("result: "+result);
        assertEquals(expResult, result);
    }

    /**
     * Test para comprobar si se obtiene la hora del fichaje de forma correcta 
     * de la base de datos
     */
    @Test
    public void testObtenerHoraFichaje() {
        System.out.println("obtenerHoraFichaje");
        Checkin instance = new Checkin(3);
        LocalTime expResult = LocalTime.parse("11:22:29");
        LocalTime result = instance.obtenerHoraFichaje();
        
        System.out.println("expResult: "+expResult);
        System.out.println("result: "+result);
        assertEquals(expResult, result);
    }

    /**
     * Test para comprobar si se obtiene la hora de la entrada de forma correcta 
     * de la base de datos
     */
    @Test
    public void testObtenerHoraHorario() {
        System.out.println("obtenerHoraHorario");
        Checkin instance = new Checkin(3);
        LocalTime expResult = LocalTime.parse("15:00:00");
        LocalTime result = instance.obtenerHoraHorario();
        
        System.out.println("expResult: "+expResult);
        System.out.println("result: "+result);        
        assertEquals(expResult, result);
    }

    /**
     * Test of comprobarHora method, of class Checkin.
     */
    @Test
    public void testComprobarHora() {
        System.out.println("comprobarHora");
        Checkin instance = new Checkin(3);
        instance.comprobarHora();
        // TODO review the generated test code and remove the default call to fail.
        fail("The test case is a prototype.");
    }
}
