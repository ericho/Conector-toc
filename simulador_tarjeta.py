'''
Created on 03/01/2012

@author: erich
'''

import random

class simulador(object):
    '''
    Generador de datos aleatorios para simular la tarjeta TOC
    '''


    def __init__(self, controlador):
        '''
        Constructor
        '''
        self.controlador = controlador
        self.contador_trama = 0
        self.crear_datos_simulador()
        
    def crear_datos_simulador(self):
        """ Genera las cadenas aleatorias """
        self.trama_datos = []
        # Biodigestor metano
              
        toc_1 = "TOC,01," + "%.2f" % (random.randint(25, 100) + random.random()) + ","
        toc_1 += "%.2f" % (random.randint(25, 100) + random.random()) + ","
        toc_1 += "%d" % random.randint(20, 80) + ","
        toc_1 += "%d" % random.randint(20, 80) + ","
        toc_1 += "%d" % random.randint(0, 1) + ","
        toc_1 += "%d" % random.randint(0, 1) + ","
        toc_1 += "%d" % random.randint(0, 30) + ","
        toc_1 += "%d" % random.randint(30, 100) + ","
        toc_1 += "%d" % random.randint(500, 800)

        # Biodigestor bioetanol
        
        toc_2 = "TOC,02," + "%d" % (random.randint(300,800)) + ","
        toc_2 += "%d" % (random.randint(300, 800)) + ","
        toc_2 += "%d" % (random.randint(300, 800)) + ","
        toc_2 += "%.2f" % (random.randint(20, 100) + random.random()) + ","
        toc_2 += "%.2f" % (random.randint(20, 100) + random.random()) + ","
        toc_2 += "%.2f" % (random.randint(20, 100) + random.random()) + ","
        toc_2 += "%d" % (random.randint(20, 80)) + ","
        toc_2 += "%d" % (random.randint(20, 80))
        #toc_2 += "%d" % (random.randint(0,1))

        # Reactor Biodiesel

        toc_3 = "TOC,03," + "%.2f" % (random.randint(20,100) + random.random()) + ","
        toc_3 += "%d" % (random.randint(0, 1)) + ","
        toc_3 += "%d" % (random.randint(0, 1)) + ","
        toc_3 += "%d" % (random.randint(0, 1)) + ","
        toc_3 += "%d" % (random.randint(0, 100)) + ","
        toc_3 += "%d" % (random.randint(0, 1)) + ","
        toc_3 += "%d" % (random.randint(0, 100)) + ","
        toc_3 += "%d" % (random.randint(0, 100)) + ","
        toc_3 += "%d" % (random.randint(0, 1)) + ","
        toc_3 += "%d" % (random.randint(0, 100))

        # Calentador solar

        toc_4 = "TOC,04," + "%.2f" % (random.randint(20, 80) + random.random()) + ","
        toc_4 += "%.2f" % (random.randint(20, 80) + random.random()) + ","
        toc_4 += "%.2f" % (random.randint(20, 80) + random.random()) + ","
        toc_4 += "%.2f" % (random.randint(20, 80) + random.random()) 
        #toc_4 += "%d" % (random.randint(0, 1)) + ","
        #toc_4 += "%d" % (random.randint(0, 1)) + ","
        #toc_4 += "%d" % (random.randint(0, 1)) + ","
        #toc_4 += "%d" % (random.randint(0, 2)) + ","
        #toc_4 += "%d" % (random.randint(0, 1)) 

        # Generador eolico

        toc_5 = "TOC,05," + "%.2f" % (random.randint(10, 100) + random.random()) + ","
        toc_5 += "%.2f" % (random.randint(0, 25) + random.random()) + ","
        toc_5 += "%.2f" % (random.randint(0, 30) + random.random()) + ","
        toc_5 += "%d" % (random.randint(500, 1500))

        # Generador magnetico
        
        toc_6 = "TOC,06," + "%d" % (random.randint(0,40)) + ","
        toc_6 += "%d" % (random.randint(0,100)) + ","
        toc_6 += "%d" % (random.randint(500,1500))

        # Generador calentador Stirling

        toc_7 = "TOC,07," + "%.2f" % (random.randint(20,500) + random.random()) + ","
        toc_7 += "%.2f" % (random.randint(20, 100) + random.random()) + ","
        toc_7 += "%d" % (random.randint(300, 2500)) + ","
        toc_7 += "%.2f" % (random.randint(20, 800) + random.random())

        # Bomba de agua Stirling

        toc_8 = "TOC,08,"
        toc_8 += "%d" % (random.randint(20, 80)) + ","
        toc_8 += "%d" % (random.randint(300, 800)) + ","
        toc_8 += "%d" % (random.randint(0, 1))	

        # Lombricompostario

        toc_9 = "TOC,09," + "%d" % (random.randint(0,1)) + ","
        toc_9 += "%d" % (random.randint(1, 7)) + ","
        toc_9 += "%d" % (random.randint(20, 80)) + ","
        toc_9 += "%.2f" % (random.randint(20, 100) + random.random())

        # Acuaponia

        toc_10 = "TOC,10,"
        toc_10 += "%.2f" % (random.randint(0, 255) + random.random()) + ","
        toc_10 += "%.2f" % (random.randint(0, 255) + random.random()) + ","
        toc_10 += "%.2f" % (random.randint(0, 14)) + ","
        toc_10 += "%d" % (random.randint(0, 1)) + ","
        toc_10 += "%d" % (random.randint(20, 100)) + ","
        toc_10 += "%d" % (random.randint(0, 1)) + ","
        toc_10 += "%d" % (random.randint(20, 100)) + ","
        toc_10 += "%d" % (random.randint(0, 1)) + ","
        toc_10 += "%d" % (random.randint(20, 100)) + ","
        toc_10 += "%d" % (random.randint(0, 1)) + ","
        toc_10 += "%d" % (random.randint(20, 100)) + ","
        toc_10 += "%d" % (random.randint(20, 100)) + ","
        toc_10 += "%d" % (random.randint(0, 1)) + ","
        toc_10 += "%d" % (random.randint(20, 100)) + ","
        toc_10 += "%d" % (random.randint(20, 100))

        # Destilador solar 

        toc_11 = "TOC,11,"
        toc_11 += "%.2f" % (random.randint(10, 120) + random.random()) + ","
        toc_11 += "%.2f" % (random.randint(10, 120) + random.random()) + ","
        toc_11 += "%.2f" % (random.randint(10, 120) + random.random()) + ","
        toc_11 += "%d" % (random.randint(0, 100))

        # Condensador atmosferico

        toc_12 = "TOC,12,"
        toc_12 += "%.2f" % (random.randint(20, 80) + random.random()) + ","
        toc_12 += "%.2f" % (random.randint(20, 80) + random.random()) + ","
        toc_12 += "%.2f" % (random.randint(20, 80) + random.random()) + ","
        toc_12 += "%d" % (random.randint(20, 100)) + ","
        toc_12 += "%d" % (random.randint(20, 100)) + ","
        toc_12 += "%d" % (random.randint(0, 1)) + ","
        toc_12 += "%d" % (random.randint(0, 1)) + ","
        toc_12 += "%d" % (random.randint(10, 100))

        # Agua de lluvia

        toc_13 = "TOC,13,"
        toc_13 += "%d" % (random.randint(0, 100)) + ","
        toc_13 += "%d" % (random.randint(0, 100)) + ","
        toc_13 += "%d" % (random.randint(0, 100)) + ","
        toc_13 += "%d" % (random.randint(0, 100)) + ","
        toc_13 += "%d" % (random.randint(0, 100)) + ","
        toc_13 += "%d" % (random.randint(0, 100)) + ","
        toc_13 += "%d" % (random.randint(0, 1)) + ","
        toc_13 += "%d" % (random.randint(0, 1))

        # Autonomia de transporte

        toc_14 = "TOC,14,"
        toc_14 += "%d" % (random.randint(0, 10000))
        #toc_14 += "%d" % (random.randint(0, 2000)) + ","
        #toc_14 += "%d" % (random.randint(0, 1))

        # Enfriamiento por adsorcion

        toc_15 = "TOC,15,"
        toc_15 += "%d" % (random.randint(100, 800)) + ","
        toc_15 += "%d" % (random.randint(100, 800)) + ","
        toc_15 += "%d" % (random.randint(100, 800)) + ","
        toc_15 += "%.2f" % (random.randint(20, 100) + random.random()) + ","
        toc_15 += "%.2f" % (random.randint(20, 100) + random.random()) + ","
        toc_15 += "%.2f" % (random.randint(20, 100) + random.random()) + ","
        toc_15 += "%.2f" % (random.randint(20, 100) + random.random())

        self.trama_datos.append(toc_1)
        self.trama_datos.append(toc_2)
        self.trama_datos.append(toc_3)
        self.trama_datos.append(toc_4)
        self.trama_datos.append(toc_5)
        self.trama_datos.append(toc_6)
        self.trama_datos.append(toc_7)
        self.trama_datos.append(toc_8)
        self.trama_datos.append(toc_9)
        self.trama_datos.append(toc_10)
        self.trama_datos.append(toc_11)
        self.trama_datos.append(toc_12)
        self.trama_datos.append(toc_13)
        self.trama_datos.append(toc_14)
        self.trama_datos.append(toc_15)


    def leer_tarjeta(self):
        if self.contador_trama > 14:
            self.crear_datos_simulador()
            self.contador_trama = 0
        
        trama = self.trama_datos[self.contador_trama]
        self.contador_trama += 1
        return trama
    
    def leer_datos(self):
        pass
    
    def desconectar(self):
        pass
            