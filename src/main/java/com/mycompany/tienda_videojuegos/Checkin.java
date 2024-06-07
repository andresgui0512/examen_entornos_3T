/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.tienda_videojuegos;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.LocalDate;
import java.time.LocalTime;
import javax.swing.JOptionPane;

/**
 * Clase 
 * 
 * @author andre
 */
public class Checkin {

    private int id;

    public Checkin(int id) {
        this.id = id;
    }

    public LocalDate obtenerFechaDeEntrada() {
        LocalDate fechaEntrada = null;

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT DATE(fecha_entrada) AS fecha FROM fichajes WHERE empleado_id=?";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setInt(1, id);

                try (ResultSet resultado = ps.executeQuery()) {
                    while (resultado.next()) {
                        fechaEntrada = resultado.getDate("fecha").toLocalDate();
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

        return fechaEntrada;
    }

    public LocalTime obtenerHoraFichaje() {
        LocalTime horaLocal = null;

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT TIME(fecha_entrada) AS hora FROM fichajes WHERE empleado_id=?";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setInt(1, id);

                try (ResultSet resultado = ps.executeQuery()) {
                    while (resultado.next()) {
                        horaLocal = LocalTime.parse(resultado.getString("hora"));
                        System.out.println("LocalTime hora: " + horaLocal);
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

        return horaLocal;
    }

    public LocalTime obtenerHoraHorario() {
        LocalTime horaLocal = null;

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
            String sql = "SELECT hora_entrada FROM empleados WHERE id=?";

            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setInt(1, id);

                try (ResultSet resultado = ps.executeQuery()) {
                    while (resultado.next()) {
                        horaLocal = LocalTime.parse(resultado.getString("hora_entrada"));
                        System.out.println("LocalTime hora: " + horaLocal);
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

        return horaLocal;
    }

    public void comprobarHora() {

        //Se obtienen las horas a comparar
        LocalDate fechaEntrada = obtenerFechaDeEntrada(); //Fecha a la que fichó
        LocalDate fechaActual = LocalDate.now();          //Fecha actual del sistema
        LocalTime horaFichaje = obtenerHoraFichaje();        //Hora a la que fichó
        LocalTime horaHorario = obtenerHoraHorario(); //Hora de entrada del horario

        System.out.println("Fecha actual: " + fechaActual);
        System.out.println("Fecha entrada: " + fechaEntrada);

        //Compara la fecha actual con la fecha del último fichaje para determinar si ha fichado hoy
        if (fechaActual.isEqual(fechaEntrada)) {
            JOptionPane.showMessageDialog(null, "Hoy fichaste");

            System.out.println("Id del empleado: " + id);
            System.out.println("Hora del fichaje: " + horaFichaje);
            System.out.println("Hora de entrada del horario: " + horaHorario);

            //Si la hora en la que fichó el empleado no coincide con la hora de entrada
            //del horario se crea una ventana emergente
            if (horaFichaje.isAfter(horaHorario)) {

                String motivo = JOptionPane.showInputDialog(null, "¿Por qué llegas tarde?");

                if (motivo != null) {
                    System.out.println("Motivo de llegada tarde: " + motivo);

                    try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/anmafe_games_bd", "root", "")) {
                        String sql = "UPDATE fichajes SET comentarios = ? WHERE empleado_id = ? AND DATE(fecha_entrada) = ?";
                        try (PreparedStatement ps = conn.prepareStatement(sql)) {
                            ps.setString(1, motivo);
                            ps.setInt(2, id);
                            ps.setString(3, fechaEntrada.toString());
                            ps.executeUpdate();
                            JOptionPane.showMessageDialog(null, "Tu mensaje ha sido enviado");
                        }
                    } catch (SQLException e) {
                        e.printStackTrace();
                        JOptionPane.showMessageDialog(null, "Error al actualizar la base de datos: " + e.getMessage());
                    }
                } else {
                    System.out.println("El usuario canceló la entrada del motivo.");
                }

            } else if (horaFichaje.isBefore(horaHorario)) {
                JOptionPane.showMessageDialog(null, "Llegaste temprano");
            } else {
                System.out.println("Id del empleado: " + id);
                System.out.println("Hora del fichaje: " + horaFichaje);
                System.out.println("Hora de entrada del horario: " + horaHorario);
                System.out.println("Entró a la hora");
            }

            //Si la fecha del último fichaje es después de la fecha actual puede significar dos cosas
            //o la fecha del sistema está desactualizada o viajó en el tiempo
        } else if (fechaActual.isBefore(fechaEntrada)) {
            JOptionPane.showMessageDialog(null, "Viajaste en el tiempo");

            //Si la fecha del último fichaje es antes de la fecha actual significa
            //que no ha fichado hoy
        } else if (fechaActual.isAfter(fechaEntrada)) {
            JOptionPane.showMessageDialog(null, "Hoy no has fichado");
        }
    }
}
