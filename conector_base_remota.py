'''
Created on 14/02/2012

@author: erich
'''
import MySQLdb

class conector_remoto():
    '''
    Clase que lee la pila de SQL para enviar a la base de datos central. 
    '''


    def __init__(self, controlador):
        '''
        Recibe un objeto controlador, haciendo referencia al objeto base, para uso de funciones
        en ese objeto. 
        '''
        self.controlador = controlador
        self.id_localizacion = self.controlador.id_localizacion
        # Datos de conexion, debera cambiarse de acuerdo a las necesidades. 
        self.host = "toc.servehttp.com"
        self.usuario = "toc"
        self.password = "CIETOC06"
        self.bd = "toc_bd"
        
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
            return True
        except MySQLdb.Error, e:
            print 'No se pudo acceder'
            print "El comando %s" % (comando)
            print 'Error %d: %s' % (e.args[0], e.args[1])
            return False
        
    
