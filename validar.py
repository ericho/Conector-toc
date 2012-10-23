# -*- coding: utf-8 -*-

'''
Created on 12/12/2011

@author: Erich Cordoba
'''

class validador():
    ''' Clase para validar los errores en las
    tramas recibidas por la tarjeta '''
    def __init__(self, controlador):
        ''' Constructor de la clase '''
        self.controlador = controlador

    def validar_biodigestor_metano(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            float(trama[4])
            int(trama[5])
            bool(trama[6])
            bool(trama[7])
            int(trama[8])
            int(trama[9])
            float(trama[10])
            return True
        except:
            cadena_excepcion = "Trama Biodigestor Metano incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False

    def validar_torre_bioetanol(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            float(trama[4])
            float(trama[5])
            float(trama[6])
            float(trama[7])
            int(trama[8])
            int(trama[9])
            return True
        except:
            cadena_excepcion = "Trama Torre Bioetanol incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False	

    def validar_reactor_biodiesel(self, trama):
        try:
            float(trama[2])
            bool(trama[3])
            bool(trama[4])
            bool(trama[5])
            int(trama[6])
            bool(trama[7])
            int(trama[8])
            int(trama[9])
            bool(trama[10])
            int(trama[11])
            return True
        except:
            cadena_excepcion = "Trama Reactor Biodiesel incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
			
    def validar_calentador_solar(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            float(trama[4])
            float(trama[5])
            return True
        except:
            cadena_excepcion = "Trama Calentador Solar incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
			
    def validar_generador_eolico(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            float(trama[4])
            int(trama[5])
            return True
        except:
            cadena_excepcion = "Trama Generador Eolico incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
		
    def validar_generador_magnetico(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            int(trama[4])
            return True
        except:
            cadena_excepcion = "Trama Generador Magnetico incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
		
    def validar_generador_stirling(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            int(trama[4])
            float(trama[5])
            return True
        except:
            cadena_excepcion = "Trama Generador Stirling incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
		
    def validar_bomba_stirling(self, trama):
        try:
            int(trama[2])
            int(trama[3])
            int(trama[4])
            return True
        except:
            cadena_excepcion = "Trama Bomba Stirling incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False

    def validar_lombricomposta(self, trama):
        try:
            bool(trama[2])
            int(trama[3])
            int(trama[4])
            float(trama[5])
            return True
        except:
            cadena_excepcion = "Trama Bomba Stirling incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
			
    def validar_acuaponia(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            float(trama[4])
            bool(trama[5])
            int(trama[6])
            bool(trama[7])
            int(trama[8])
            bool(trama[9])
            int(trama[10])
            bool(trama[11])
            int(trama[12])
            int(trama[13])
            bool(trama[14])
            int(trama[15])
            int(trama[16])
            return True
        except:
            cadena_excepcion = "Trama Acuaponia incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
		
    def validar_destilador_solar(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            float(trama[4])
            int(trama[5])
            return True
        except:
            cadena_excepcion = "Trama Destilador Solar incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
		
    def validar_condensador_atmosferico(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            float(trama[4])
            int(trama[5])
            int(trama[6])
            bool(trama[7])
            bool(trama[8])
            int(trama[9])
            return True
        except:
            cadena_excepcion = "Trama Condensador Atmosferico incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
			
    def validar_agua_de_lluvia(self, trama):
        try:
            int(trama[2])
            int(trama[3])
            int(trama[4])
            int(trama[5])
            int(trama[6])
            int(trama[7])
            bool(trama[8])
            bool(trama[9])
            return True
        except:
            cadena_excepcion = "Trama Agua de lluvia incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
			
    def validar_autonomia_transporte(self, trama):
        try:
            int(trama[2])
            return True
        except:
            cadena_excepcion = "Trama Autonomia de transporte incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
			
    def validar_enfriamiento_adsorcion(self, trama):
        try:
            float(trama[2])
            float(trama[3])
            float(trama[4])
            float(trama[5])
            float(trama[6])
            float(trama[7])
            float(trama[8])
            return True
        except:
            cadena_excepcion = "Trama Enfriamiento por Adsorcion incorrecta : %s" % (trama)
            self.controlador.logs.exception(cadena_excepcion)
            return False
