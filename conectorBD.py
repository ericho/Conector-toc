'''
Created on 12/12/2011

@author: Erich Cordoba
'''

import MySQLdb
from datetime import datetime

class conectorBD():
    '''
    Clase para enviar y recibir informacion a la base de datos. 
    '''


    def __init__(self, controlador):
        '''
        Constructor de la clase
        Se generan las constantes para la cadena de conexion. 
        Se recibe un objeto controlador como contexto de la instancia padre.
        '''
        self.controlador = controlador
        self.id_localizacion = self.controlador.id_localizacion
        # Datos de conexion, debera cambiarse de acuerdo a las necesidades. 
        self.host = "localhost"
        self.usuario = "erich"
        self.password = "12345"
        self.bd = "toc_test"

    def conectar(self):
        '''
        Genera la conexion con el servidor MySQL
        Devuelve True si la conexion es valida
        de lo contrario devuelve False.  
        '''
        try:
            self.base = MySQLdb.connect(host=self.host,
                                        user=self.usuario,
                                        passwd=self.password,
                                        db=self.bd)
        except MySQLdb.Error, e:
            print 'No se pudo acceder'
            print 'Error %d: %s' % (e.args[0], e.args[1])
            return False
        self.cursor = self.base.cursor()
        return True
    
    def desconectar(self):
        ''' Se desconecta de la base de datos '''
        self.cursor.close()
        
    def ejecutar_comando(self, comando):
        ''' Ejecuta un comando en la base de datos.
            Recibe como parametro la sentencia SQL a ejecutar
        '''
        try:
            self.cursor.execute(comando)
            self.base.commit()
        except MySQLdb.Error, e:
            print 'No se pudo acceder'
            print "El comando %s" % (comando)
            print 'Error %d: %s' % (e.args[0], e.args[1])

    def insertar_evento(self, fecha, modulo, evento):
        comando = "INSERT INTO bitacora VALUES(NULL,"
        comando += modulo + ","
        comando += self.id_localizacion + ","
        comando += "'" + evento + "',"
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "')"
        self.ejecutar_comando(comando)
        return comando

    def insertar_biodigestor_metano(self, 
                                    fecha, 
                                    temp_mezcla, 
                                    temp_reactor, 
                                    nivel_reactor, 
                                    nivel_deposito_gas, 
                                    res_calentador_agua, 
                                    motor_agitador_a, 
                                    motor_agitador_b_time_on,
                                    motor_agitador_c_frec,
                                    presion_gas):
        ''' Recibe las variables de la trama para el modulo biodigestor metano
            y ejecuta el comando SQL para incluir en la base de datos. 
        '''
        MODULO = "1"
        comando = "INSERT INTO biodigestor_metano VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += temp_mezcla + ","
        comando += temp_reactor + ","
        comando += nivel_reactor + ","
        comando += nivel_deposito_gas + ","
        comando += res_calentador_agua + ","
        comando += motor_agitador_a + ","
        comando += motor_agitador_b_time_on + ","
        comando += motor_agitador_c_frec + ","
        comando += presion_gas + ")"

        self.ejecutar_comando(comando)
        return comando

    def insertar_torre_bioetanol(self,
                                       fecha,
                                       pres_reactor,
                                       pres_contenedor,
                                       presion_3,
                                       temp_contenedor,
                                       temp_reactor,
                                       temp_almacenaje,
                                       nivel_mezcla,
                                       nivel_condensador):
        ''' Obtiene los valores de la trama torre bioetanol y los almacena en la base de datos
        '''
        
        MODULO = "2"
        comando = "INSERT INTO torre_bioetanol VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += pres_reactor + ","
        comando += pres_contenedor + ","
        comando += temp_contenedor + ","
        comando += temp_reactor + ","
        comando += temp_almacenaje + ","
        comando += nivel_mezcla + ","
        comando += nivel_condensador + ","
        comando += presion_3 + ")"

        self.ejecutar_comando(comando)
        return comando

    def insertar_reactor_biodiesel(self, 
                                   fecha,
                                   temp_reactor, 
                                   bomba_1, 
                                   bomba_2, 
                                   agitador_1a_estado, 
                                   agitador_1b_tiempo, 
                                   agitador_2a_estado, 
                                   agitador_2b_tiempo, 
                                   agitador_2c_tiempo,
                                   calentador_estado, 
                                   calentador_tiempo):
        
        MODULO = "3"
        comando = "INSERT INTO reactor_biodiesel VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += temp_reactor + ","
        comando += bomba_1 + ","
        comando += bomba_2 + ","
        comando += agitador_1a_estado + ","
        comando += agitador_1b_tiempo + ","
        comando += agitador_2a_estado + ","
        comando += agitador_2b_tiempo + ","
        comando += calentador_estado + ","
        comando += calentador_tiempo + ","
        comando += agitador_2c_tiempo + ")"
        
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_calentador_solar(self, 
                                  fecha, 
                                  temp_agua_fria, 
                                  temp_agua_caliente, 
                                  temp_salida_agua, 
                                  temp_tuberia,
                                  sensor_ldr1,
                                  sensor_ldr2,
                                  sensor_ldr3,
                                  posicion_calentador,
                                  motor_seguidor):
        
        MODULO = "4"
        comando = "INSERT INTO calentador_solar VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += temp_agua_fria + ","
        comando += temp_agua_caliente + ","
        comando += temp_salida_agua + ","
        comando += temp_tuberia + ","
        comando += sensor_ldr1 + ","
        comando += sensor_ldr2 + ","
        comando += sensor_ldr3 + ","
        comando += posicion_calentador + ","
        comando += motor_seguidor + ")"
        
        self.ejecutar_comando(comando)
        return comando
        

    def insertar_generador_eolico(self, 
                                  fecha, 
                                  voltaje, 
                                  velocidad_viento, 
                                  potencia,
                                  rpm):
        MODULO = "5"
        comando = "INSERT INTO generador_eolico VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += voltaje + ","
        comando += velocidad_viento + ","
        comando += potencia + ","
        comando += rpm + ")"
        
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_generador_magnetico(self,
                                     fecha,
                                     corriente,
                                     voltaje,
                                     rpm):
        
        MODULO = "6"
        comando = "INSERT INTO generador_magnetico VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += corriente + ","
        comando += voltaje + ","
        comando += rpm + ")"
         
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_generador_calentador_stirling(self, 
                                               fecha, 
                                               temp_entrada_caliente,
                                               temp_entrada_fria, 
                                               rpm, 
                                               presion):
        MODULO = "7"
        comando = "INSERT INTO generador_calentador_stirling VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += temp_entrada_caliente + ","
        comando += temp_entrada_fria + ","
        comando += rpm + ","
        comando += presion + ")"
        
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_bomba_de_agua(self):
        pass
    
    def insertar_lombricompostario(self, 
                                   fecha,
                                   motor_estado,
                                   motor_frecuencia,
                                   humedad,
                                   temperatura):
        MODULO = "9"
        comando = "INSERT INTO lombricompostario VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += motor_estado + ","
        comando += motor_frecuencia + ","
        comando += humedad + ","
        comando += temperatura + ")"
        
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_acuaponia(self,
                           fecha,
                           temp_ambiente,
                           temp_agua,
                           ph,
                           dispensador_1a,
                           dispensador_1b,
                           dispensador_2a,
                           dispensador_2b,
                           dispensador_3a,
                           dispensador_3b,
                           bomba_1a,
                           bomba_1b,
                           bomba_1c,
                           bomba_2a,
                           bomba_2b,
                           bomba_2c):
        MODULO = "10"
        comando = "INSERT INTO acuaponia VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += temp_ambiente + ","
        comando += temp_agua  + ","
        comando += ph + ","
        comando += dispensador_1a + ","
        comando += dispensador_1b + ","
        comando += dispensador_2a + ","
        comando += dispensador_2b + ","
        comando += dispensador_3a + ","
        comando += dispensador_3b + ","
        comando += bomba_1a + ","
        comando += bomba_1b + ","
        comando += bomba_1c + ","
        comando += bomba_2a + ","
        comando += bomba_2b + ","
        comando += bomba_2c + ")"
        
        self.ejecutar_comando(comando)
        return comando
    
    def insertar_destilador_solar(self, 
                                  fecha,
                                  temperatura_sol, 
                                  temperatura_lente, 
                                  temperatura_interna,
                                  nivel_contenedor):
        MODULO = "11"
        comando = "INSERT INTO destilador_solar VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += temperatura_sol + ","
        comando += temperatura_lente + ","
        comando += temperatura_interna + ","
        comando += nivel_contenedor + ")"
        
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_condensador_atmosferico(self,
                                         fecha,
                                         temp_ambiente,
                                         temp_interior,
                                         temp_agua,
                                         sensor_humedad,
                                         ldr_estado,
                                         motor_estado,
                                         flujo_agua):
        MODULO = "12"
        comando = "INSERT INTO condensador_atmosferico VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += temp_ambiente + ","
        comando += temp_interior + ","
        comando += temp_agua + ","
        comando += sensor_humedad + ","
        comando += ldr_estado + ","
        comando += motor_estado + ","
        comando += flujo_agua + ")"
        
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_agua_de_lluvia(self,
                                fecha,
                                nivel_1,
                                nivel_2,
                                nivel_3,
                                nivel_4,
                                nivel_5,
                                nivel_6,
                                bomba_1,
                                bomba_2):
        MODULO = "13"
        comando = "INSERT INTO agua_de_lluvia VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += nivel_1 + ","
        comando += nivel_2 + ","
        comando += nivel_3 + ","
        comando += nivel_4 + ","
        comando += nivel_5 + ","
        comando += nivel_6 + ","
        comando += bomba_1 + ","
        comando += bomba_2 + ")"
#        comando += bomba_3 + ")"
        
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_autonomia_transporte(self,
                                      fecha,
                                      inclinacion,
                                      rpm,
                                      alternador):
        MODULO = "14"
        comando = "INSERT INTO autonomia_transporte VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += inclinacion + ","
        comando += rpm + ","
        comando += alternador + ")"
        
        self.ejecutar_comando(comando)
        return comando
        
    def insertar_enfriamiento_adsorcion(self,
                                        fecha,
                                        presion,
                                        presion_domo, 
                                        temp_fria, 
                                        temp_caliente, 
                                        temp_salida_caliente,
                                        temp_tuberia):
        MODULO="15"
        comando = "INSERT INTO enfriamiento_adsorcion VALUES(NULL,"
        comando += MODULO + ","
        comando += self.id_localizacion + ","
        comando += "'" + fecha.strftime('%Y-%m-%d %H:%M:%S') + "',"
        comando += presion + ","
        comando += presion_domo + ","
        comando += temp_fria + ","
        comando += temp_caliente + ","
        comando += temp_salida_caliente + ","
        comando += temp_tuberia + ")"
        
        self.ejecutar_comando(comando)
        return comando
    