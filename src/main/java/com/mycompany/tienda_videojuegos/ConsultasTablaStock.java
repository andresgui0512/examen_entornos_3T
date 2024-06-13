/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.tienda_videojuegos;

import java.sql.Array;
import java.sql.Connection;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.util.ArrayList;
import javax.swing.JFrame;
import javax.swing.JTable;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableModel;

/**
 *
 * @author Federico
 */
public class ConsultasTablaStock extends JFrame {

    public ConsultasTablaStock() {

    }

    public void insertarFila() {

    }

    public ArrayList<String> obtenerProductos() {
        ArrayList<String> productos = new ArrayList<>();

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT nombre FROM productos";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {

                try (ResultSet resultado = ps.executeQuery()) {

                    while (resultado.next()) {
                        productos.add(resultado.getString("nombre"));

                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            } catch (Exception e) {
                e.printStackTrace();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return productos;
    }

    public ArrayList<String> mostrarTiendasTotales() {
        ArrayList<String> tiendasTotales = new ArrayList<>();

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT nombre FROM tiendas;";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {

                try (ResultSet resultado = ps.executeQuery()) {

                    while (resultado.next()) {
                        tiendasTotales.add(resultado.getString("nombre"));

                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            } catch (Exception e) {
                e.printStackTrace();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return tiendasTotales;
    }

    public String comprobarUsuario() {

        String nombrePuesto = "";

        VentanaInicioSesion sesion = VentanaInicioSesion.obtenerInstancia();
        System.out.println("Sesion: " + sesion.getNombre());

        String usuario = sesion.getNombre();

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT puesto FROM empleados where nombre = ? ;";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setString(1, usuario);
                try (ResultSet resultado = ps.executeQuery()) {

                    while (resultado.next()) {
                        nombrePuesto = resultado.getString("puesto");

                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            } catch (Exception e) {
                e.printStackTrace();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return nombrePuesto;
    }

    public ArrayList<String> obtenerCabecerasTabla() {

        ArrayList<String> cabcerasTabla = new ArrayList<>();

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT * FROM inventario;";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {

                try (ResultSet rs = ps.executeQuery(sql)) {

                    // Obtener metadatos del ResultSet
                    ResultSetMetaData metaData = rs.getMetaData();
                    int columnCount = metaData.getColumnCount();

                    // Añadir nombres de columnas a este arraylist
                    for (int column = 1; column <= columnCount; column++) {
                        cabcerasTabla.add(metaData.getColumnName(column));
                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            } catch (Exception e) {
                e.printStackTrace();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return cabcerasTabla;
    }

    public void mostrardatos(JTable tabla, DefaultTableModel modelo) {

//        ArrayList<String> nomCols = new ArrayList<>();
//        ArrayList<String> celdas = new ArrayList<>();
        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT * FROM inventario;";
            try (PreparedStatement prepararConsulta = conn.prepareStatement(sql)) {

                try (ResultSet rs = prepararConsulta.executeQuery()) {
                    ResultSetMetaData metaData = rs.getMetaData();
                    int columnCount = metaData.getColumnCount();

                    // Imprimir los nombres de las columnas
//                    for (int i = 1; i <= columnCount; i++) {
//                        nomCols.add(metaData.getColumnName(i)) ;
//                    }
                    while (rs.next()) {
                        //BigDecimal hoursWorked = resultado.getBigDecimal("HoursWorked");
                        //BigDecimal salary = resultSet.getBigDecimal("Salary");
                        // Add row to the table model

                        modelo.addRow(new Object[]{
                            rs.getInt("id"),
                            rs.getString("producto_id"),
                            rs.getString("tienda_id"),
                            rs.getInt("cantidad"),
                            rs.getString("estado"),
                            rs.getDate("fecha"),});
                    }
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public ArrayList<String> obtenerTiendasTabla() {
        ArrayList<String> productos = new ArrayList<>();

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT nombre FROM tiendas";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {

                try (ResultSet resultado = ps.executeQuery()) {

                    while (resultado.next()) {
                        productos.add(resultado.getString("nombre"));

                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            } catch (Exception e) {
                e.printStackTrace();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return productos;
    }

    public void obtenerDatosTablaFichaje(DefaultTableModel modelo, int id) {

        try (Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sentencia = "SELECT puesto FROM empleados WHERE id=?";

            try (PreparedStatement ps = con.prepareStatement(sentencia)) {

                ps.setInt(1, id);
                
                try (ResultSet resultado = ps.executeQuery()) {

                    while (resultado.next()) {
                        
                        //Si el empleado es igual a gestor se muestran todos los fichajes
                        if (resultado.getString("puesto").equals("gestor")) {

                            try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
                                String sql = "SELECT * FROM fichajes"; //Todos los fichajes

                                try (PreparedStatement pss = conn.prepareStatement(sql)) {

                                    try (ResultSet resultados = pss.executeQuery()) {

                                        while (resultados.next()) {
                                            modelo.addRow(new Object[]{
                                                resultados.getInt("empleado_id"),
                                                resultados.getString("fecha_entrada"),
                                                resultados.getString("fecha_salida"),
                                                resultados.getString("comentarios"),});
                                        }

                                    } catch (Exception e) {
                                        e.printStackTrace();
                                    }
                                } catch (Exception e) {
                                    e.printStackTrace();
                                }

                            } catch (Exception e) {
                                e.printStackTrace();
                            }

                        }else{ //Si el empleado no es gestor solo se muestran sus fichajes
                            
                            try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
                                String sql = "SELECT * FROM fichajes WHERE empleado_id=?";//Los fichajes con el mismo id

                                try (PreparedStatement pss = conn.prepareStatement(sql)) {

                                    pss.setInt(1, id);
                                    
                                    try (ResultSet resultados = pss.executeQuery()) {

                                        while (resultados.next()) {
                                            modelo.addRow(new Object[]{
                                                resultados.getInt("empleado_id"),
                                                resultados.getString("fecha_entrada"),
                                                resultados.getString("fecha_salida"),
                                                resultados.getString("comentarios"),});
                                        }

                                    } catch (Exception e) {
                                        e.printStackTrace();
                                    }
                                } catch (Exception e) {
                                    e.printStackTrace();
                                }

                            } catch (Exception e) {
                                e.printStackTrace();
                            }                            
                            
                        }
                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            } catch (Exception e) {
                e.printStackTrace();
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
