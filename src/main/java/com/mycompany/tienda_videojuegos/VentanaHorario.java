/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.tienda_videojuegos;

/**
 *
 * @author andre
 */
import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.*;
import java.util.ArrayList;

/**
 * Clase que crea la ventana donde aparece el horario
 * del empleado, si es administrador tendrá la capacidad 
 * de ver todos los horarios.
 * 
 * @author andre
 */
public class VentanaHorario extends JFrame {

    private int id;
    private JTable table;
    private DefaultTableModel model;
    private boolean esAdmin;
    
    /**
     * Recibe el id que servirá para realizar las consultas
     * del empleado y llama a la función initComponents.
     * 
     * @param id valor entero que representa el id de la tabla empleados.
     */
    public VentanaHorario(int id, boolean esAdmin) {
        this.id = id;
        this.esAdmin = esAdmin;
        initComponents();
    }

    /**
     * Función que crea la interfaz de la ventana
     */
    private void initComponents() {
        setTitle("Horario del Empleado");
        setSize(800, 600);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        setLocationRelativeTo(null);
        setLayout(new BorderLayout());

        // Crear el modelo de la tabla
        model = new DefaultTableModel();
        model.addColumn("Día de la Semana");
        model.addColumn("Hora de Entrada");
        model.addColumn("Hora de Salida");

        // Crear la tabla con el modelo
        table = new JTable(model);
        table.setFont(new Font("Arial", Font.PLAIN, 14));
        table.setRowHeight(30);
        table.getTableHeader().setFont(new Font("Arial", Font.BOLD, 16));
        JScrollPane scrollPane = new JScrollPane(table);

        // Crear un panel para contener la tabla y los botones
        JPanel panel = new JPanel(new BorderLayout());
        panel.add(scrollPane, BorderLayout.CENTER);

        // Crear un panel para los botones
        JPanel buttonPanel = new JPanel(new FlowLayout(FlowLayout.RIGHT));
        JButton refreshButton = new JButton("Refrescar");
        JButton closeButton = new JButton("Cerrar");

        refreshButton.setFont(new Font("Arial", Font.BOLD, 14));
        closeButton.setFont(new Font("Arial", Font.BOLD, 14));

        // Añadir acción al botón de refrescar
        refreshButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                refrescarDatos();
            }
        });

        // Añadir acción al botón de cerrar
        closeButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                dispose();
            }
        });

        buttonPanel.add(refreshButton);
        buttonPanel.add(closeButton);
        panel.add(buttonPanel, BorderLayout.SOUTH);

        add(panel, BorderLayout.CENTER);

        // Obtener datos y rellenar la tabla
        crearTablaHorario(model);
        
        //Si es administrador se crean las opciones de edición de los horarios
        if(esAdmin){
            crearOpcionesEdicionHorarios();
        }
    }

    /**
     * Función que recibe el modelo de la tabla
     * para realizar una consulta a la base de datos y obtener los horarios
     * y luego agregarlos al modelo.
     * 
     * @param model modelo de la tabla donde va a añadir los resultados.
     */
    private void crearTablaHorario(DefaultTableModel model) {
        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT horario_entrada, horario_salida, dia_semana FROM horarios WHERE empleado_id=?";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setInt(1, id);

                try (ResultSet resultado = ps.executeQuery()) {
                    while (resultado.next()) {
                        String diaSemana = resultado.getString("dia_semana");
                        Time horarioEntrada = resultado.getTime("horario_entrada");
                        Time horarioSalida = resultado.getTime("horario_salida");

                        // Añadir los datos al modelo de la tabla
                        model.addRow(new Object[]{diaSemana, horarioEntrada.toString(), horarioSalida.toString()});
                    }
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            } catch (SQLException e) {
                e.printStackTrace();
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
    
    public void crearOpcionesEdicionHorarios(){
        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT estado FROM empleados WHERE empleado_id=?";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setInt(1, id);

                try (ResultSet resultado = ps.executeQuery()) {
                    while (resultado.next()) {
                        String estado = resultado.getString("estado");

                    }
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            } catch (SQLException e) {
                e.printStackTrace();
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } 
    }
    
    
    /**
     * Actualiza los datos de la tabla de horarios
     */
    private void refrescarDatos() {
        // Limpiar el modelo de la tabla
        model.setRowCount(0);
        // Volver a obtener los datos
        crearTablaHorario(model);
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> {
            VentanaHorario frame = new VentanaHorario(2,true); // Cambia el ID del empleado según sea necesario
            frame.setVisible(true);
        });
    }




















    /**
     * Función creada para realizar pruebas, no afecta al programa
     * obtiene los dias de la semana en los que trabaja un empleado
     * 
     * @param empleadoId id del empleado a buscar.
     * @return Array con todos los días de la semana
     */
    public String[] obtenerDiasSemana(int empleadoId) {
        
        ArrayList<String> diasSemana = new ArrayList<>();
        
        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT DISTINCT dia_semana FROM horarios WHERE empleado_id=? ORDER BY FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setInt(1, empleadoId);

                try (ResultSet resultado = ps.executeQuery()) {
                    while (resultado.next()) {
                        diasSemana.add(resultado.getString("dia_semana"));
                    }
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            } catch (SQLException e) {
                e.printStackTrace();
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return diasSemana.toArray(new String[0]);
    }
}