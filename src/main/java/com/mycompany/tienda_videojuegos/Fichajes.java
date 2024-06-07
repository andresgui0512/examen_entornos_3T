/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.tienda_videojuegos;

import java.awt.FlowLayout;
import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.table.DefaultTableModel;

/**
 * Clase que crea la ventana de la sección de fichajes
 *
 * @author Federico
 */
public class Fichajes extends JFrame {

    private JTable tablaFichar;
    private JPanel panelFichaje;
    private JScrollPane barra;
    private int id;

    /**
     * Recibe el id del empleado que inició sesión y llama a la función
     * initComponents.
     *
     * @param id int que representa el id del empleado en la tabla empleados
     */
    public Fichajes(int id) {
        this.id = id;
        initComponents();
    }

    /**
     * Crea la interfaz de la sección de fichajes
     */
    private void initComponents() {

        this.setSize(877, 655);
        this.panelFichaje = new JPanel();
        this.panelFichaje.setSize(877, 655);
        this.setLayout(new FlowLayout());
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);

        DefaultTableModel modelo = new DefaultTableModel();

        modelo.addColumn("empleado_id");
        modelo.addColumn("fecha_entrada");
        modelo.addColumn("fecha_salida");
        modelo.addColumn("comentarios");

        this.tablaFichar = new JTable();
        this.tablaFichar = new JTable(modelo);

        this.barra = new JScrollPane();
        this.barra = new JScrollPane(tablaFichar);

        //metodo para mostrar los fichajes de los empleados
        new ConsultasTablaStock().obtenerDatosTablaFichaje(modelo, id);
        this.panelFichaje.add(this.barra);
        this.add(this.panelFichaje);
        this.setVisible(true);
    }

    //Pendiente de seguir revisando
    //Es una prueba hecha por Andrés
    public void mostrarEmpleadosFichados() {
        String query = "SELECT e.id AS empleado_id, e.nombre, e.apellido, f.fecha_entrada, f.fecha_salida "
                + "FROM empleados e "
                + "JOIN fichajes f ON e.id = f.empleado_id "
                + "WHERE e.superior = ? AND DATE(f.fecha_entrada) = CURDATE()";
    }
}
