'''
Created on 12/12/2011

@author: Erich Cordoba
'''

from serial import Serial
import time


class tarjetaTOC():
    '''
    Clase de comunicacion con la tarjeta mediante puerto serial. 
    '''


    def __init__(self, controlador):
        '''
        Constructor de la clase
        '''
        self.puerto = "/dev/ttyS0"
        self.BAUDS = "9600"
        self.TIMEOUT = 1
        
        self.serial = Serial(port=self.puerto,
                             baudrate=self.BAUDS,
                             bytesize=8,
                             stopbits=1,
                             timeout=self.TIMEOUT,
                             dsrdtr=False,
                             rtscts=True)
        self.cerrar_puerto()
        
    def abrir_puerto(self):
        try:
            self.serial.open()
            #time.sleep(2)
        except:
            print "Error de apertura de puerto"
    
    def cerrar_puerto(self):
        self.serial.close()
        
    def desconectar(self):
        self.cerrar_puerto()
    
    def escribir_datos(self, datos):
        # Escribe datos en el puerto
        self.serial.flushOutput()
        self.serial.write(datos)
        print "Escribio"
        
    def crear_datos_simulador(self):
        pass
        
    def leer_datos(self):
        recv = self.serial.readline()            
        if len(recv) >= 5:
            self.serial.flushInput()
            return recv
        else:
            return (recv)
        
    def enviar_comando(self, comando):
        # Envia un comando y espera a que se reciba respuesta
        self.abrir_puerto()
        self.escribir_datos(comando)
        recv = self.leer_datos()
        self.cerrar_puerto()
        return recv
        
if __name__ == "__main__":
    t = tarjetaTOC()
    t.abrir_puerto()
    str = raw_input("Espera...")
    #t.escribir_datos("TOCPC1")
    #print t.leer_datos()
    t.cerrar_puerto()
