# -*- coding: utf-8 -*-
'''
Created on 02/01/2012

@author: erich
'''

import gtk
import pygtk

class gui(object):
    '''
    Clase para la interfaz grafica. Recibe como parametro un objeto controlador
    para hacer referencia a funciones en la clase padre.
    '''


    def __init__(self, controlador):
        '''
        Constructor
        '''
        self.controlador = controlador
        self.builder = gtk.Builder()
        
        try:
        
            self.builder.add_from_file("ventana.glade")
        except:
            print "No se pudo cargar el archivo glade"
        self.ventana = self.builder.get_object("ventana_principal")
        self.builder.connect_signals(self)
        self.treeview = self.builder.get_object("treeview1")
        self.vista_eventos = self.builder.get_object("vista_eventos")
        self.vista_alarmas = self.builder.get_object("vista_alarmas")
        self.modelo_eventos = self.vista_eventos.get_model()
        self.modelo_alarmas = self.vista_alarmas.get_model()
        self.treestore = self.treeview.get_model()
        self.ltarjeta = self.builder.get_object("ltarjeta")
        self.lbase = self.builder.get_object("lbase")
        self.lservidor = self.builder.get_object("lservidor")
        self.lactividad = self.builder.get_object("lactividad")
        self.barra_estado = self.builder.get_object("statusbar1")
        self.contexto_barra = self.barra_estado.get_context_id("Barra de estado")
        self.mensaje_barra = self.barra_estado.push(self.contexto_barra, "Inicializando...")
        
        
        celda_modulo = gtk.CellRendererText()
        celda_valor = gtk.CellRendererText()
        columna_1 = gtk.TreeViewColumn("Modulo", celda_modulo, text=0)
        columna_2 = gtk.TreeViewColumn("Estado", celda_valor, text=1)
        
        celda_evento_modulo = gtk.CellRendererText()
        celda_evento_fecha = gtk.CellRendererText()
        celda_evento = gtk.CellRendererText()
        columna_eventos_1 = gtk.TreeViewColumn("Modulo", celda_evento_modulo, text=0)
        columna_eventos_2 = gtk.TreeViewColumn("Fecha", celda_evento_fecha, text=1)
        columna_eventos_3 = gtk.TreeViewColumn("Evento", celda_evento, text=2)
        
        celda_fecha_alarmas = gtk.CellRendererText()
        celda_alarma = gtk.CellRendererText()
        columna_fecha_alarmas = gtk.TreeViewColumn("Fecha", celda_fecha_alarmas, text=0)
        columna_alarma = gtk.TreeViewColumn("Alarma", celda_alarma, text=1)
        
        
        self.treeview.append_column(columna_1)
        self.treeview.append_column(columna_2)
        self.treeview.set_model(self.treestore)
        
        self.vista_eventos.append_column(columna_eventos_1)
        self.vista_eventos.append_column(columna_eventos_2)
        self.vista_eventos.append_column(columna_eventos_3)
        
        self.vista_alarmas.append_column(columna_fecha_alarmas)
        self.vista_alarmas.append_column(columna_alarma)
        
        self.llenar_campos_modelo()
        
        
        self.ventana.show()
        
        self.ventana.maximize()
        
    def on_salir_ventana(self, widget, data=None):
        self.controlador.cerrar_programa()
        
    
    def mostrar_acerca_de(self, widget, data=None):
        dialogo = self.builder.get_object("dialogo_acerca")
        dialogo.run()
        dialogo.hide()
    
    def cambiar_barra_estado(self, texto):
        self.barra_estado.remove(self.contexto_barra, self.mensaje_barra)
        self.mensaje_barra = self.barra_estado.push(self.contexto_barra, texto)
        
    
    def llenar_campos_modelo(self):
        self.modulo_1 = self.treestore.append(None, ['Biodigestor Metano', '--'])
        self.mod1_temp_mezcla = self.treestore.append(self.modulo_1, ['Temperatura mezcla', '--'])
        self.mod1_temp_reactor = self.treestore.append(self.modulo_1, ['Temperatura reactor', '--'])
        self.mod1_nivel_reactor = self.treestore.append(self.modulo_1, ['Nivel reactor', '-- '])
        self.mod1_nivel_deposito_gas = self.treestore.append(self.modulo_1, ['Nivel depósito gas', '-- '])
        self.mod1_res_calentador_agua = self.treestore.append(self.modulo_1, ['Resistencia calentador de agua', '-- '])
        self.mod1_motor_agitador_a = self.treestore.append(self.modulo_1, ['Motor agitador A', '-- '])
        self.mod1_motor_agitador_b = self.treestore.append(self.modulo_1, ['Motor agitador B tiempo', '-- '])
        self.mod1_motor_agitador_c = self.treestore.append(self.modulo_1, ['Motor agitador C frecuencia', '-- '])
        self.mod1_presion_gas = self.treestore.append(self.modulo_1, ['Presion Gas', '-- '])
        
        self.modulo_2 = self.treestore.append(None, ['Torre de bioetanol', '--'])
        self.mod2_presion_calderin = self.treestore.append(self.modulo_2, ['Presión calderin', '--'])
        self.mod2_presion_domo = self.treestore.append(self.modulo_2, ['Presión domo', '--'])
        self.mod2_presion_enchaquetado = self.treestore.append(self.modulo_2, ['Presión enchaquetado', '--'])
        self.mod2_temp_domo = self.treestore.append(self.modulo_2, ['Temperatura domo', '--'])
        self.mod2_temp_calderin = self.treestore.append(self.modulo_2, ['Temperatura calderin', '--'])
        self.mod2_temp_enchaquetado = self.treestore.append(self.modulo_2, ['Temperatura enchaquetado', '--'])
        self.mod2_nivel_mezcla_calderin = self.treestore.append(self.modulo_2, ['Nivel mezcla calderin', '--'])
        self.mod2_nivel_almacenamiento = self.treestore.append(self.modulo_2, ['Nivel almacenamiento', '--'])
        
        self.modulo_3 = self.treestore.append(None, ['Reactor biodiesel', '--'])
        self.mod3_temp_reactor = self.treestore.append(self.modulo_3, ['Temperatura reactor', '--'])
        self.mod3_bomba_1 = self.treestore.append(self.modulo_3, ['Bomba 1', '--'])
        self.mod3_bomba_2 = self.treestore.append(self.modulo_3, ['Bomba 2', '--'])
        self.mod3_agitador_1a = self.treestore.append(self.modulo_3, ['Agitador 1a', '--'])
        self.mod3_agitador_1b = self.treestore.append(self.modulo_3, ['Agitador 1b', '--'])
        self.mod3_agitador_2a = self.treestore.append(self.modulo_3, ['Agitador 2a', '--'])
        self.mod3_agitador_2b = self.treestore.append(self.modulo_3, ['Agitador 2b', '--'])
        self.mod3_agitador_2c = self.treestore.append(self.modulo_3, ['Agitador 2c', '--'])
        self.mod3_res_calentador_estado = self.treestore.append(self.modulo_3, ['Estado resistencia', '--'])
        self.mod3_res_calentador_tiempo = self.treestore.append(self.modulo_3, ['Resistencia calentador tiempo', '--'])
        
        
        self.modulo_4 = self.treestore.append(None, ['Calentador solar', '--'])
        self.mod4_temp_agua_fria = self.treestore.append(self.modulo_4, ['Temperatura tuberia 1', '--'])
        self.mod4_temp_agua_caliente = self.treestore.append(self.modulo_4, ['Temperatura tuberia 2', '--'])
        self.mod4_temp_salida_agua_fria = self.treestore.append(self.modulo_4, ['Temperatura agua fria', '--'])
        self.mod4_temp_agua_caliente = self.treestore.append(self.modulo_4, ['Temperatura agua caliente', '--'])
        #self.mod4_ldr1 = self.treestore.append(self.modulo_4, ['Sensor LDR1', '--'])
        #self.mod4_ldr2 = self.treestore.append(self.modulo_4, ['Sensor LDR2', '--'])
        #self.mod4_ldr3 = self.treestore.append(self.modulo_4, ['Sensor LDR3', '--'])
        #self.mod4_posicion_calentador = self.treestore.append(self.modulo_4, ['Posición calentador', '--'])
        #self.mod4_motor_seguidor = self.treestore.append(self.modulo_4, ['Motor seguidor', '--'])
        
        self.modulo_5 = self.treestore.append(None, ['Generador eolico', '--'])
        self.mod5_velocidad_viento = self.treestore.append(self.modulo_5, ['Velocidad viento', '--'])
        self.mod5_voltaje = self.treestore.append(self.modulo_5, ['Voltaje', '--'])
        self.mod5_potencia = self.treestore.append(self.modulo_5, ['Potencia', '--'])
        self.mod5_rpm = self.treestore.append(self.modulo_5, ['RPM', '--'])
        
        self.modulo_6 = self.treestore.append(None, ['Generador magnetico', '--'])
        self.mod6_corriente = self.treestore.append(self.modulo_6, ['Corriente', '--'])
        self.mod6_voltaje = self.treestore.append(self.modulo_6, ['Voltaje', '--'])
        self.mod6_rpm = self.treestore.append(self.modulo_6, ['RPM', '--'])
        
        self.modulo_7 = self.treestore.append(None, ['Generador motor Stirling', '--'])
        self.mod7_temp_caliente = self.treestore.append(self.modulo_7, ['Temperatura entrada caliente', '--'])
        self.mod7_temp_fria = self.treestore.append(self.modulo_7, ['Temperatura entrada fria', '--'])
        self.mod7_rpm = self.treestore.append(self.modulo_7, ['RPM', '--'])
        self.mod7_presion = self.treestore.append(self.modulo_7, ['Presion', '--'])
        
        self.modulo_8 = self.treestore.append(None, ['Bomba de agua Stirling', '--'])
        self.mod8_nivel = self.treestore.append(None, ['Nivel', '--'])
        self.mod8_rpm = self.treestore.append(None, ['RPM', '--'])	
        self.mod8_servo_motor = self.treestore.append(None, ['Servo Motor', '--'])
        
        self.modulo_9 = self.treestore.append(None, ['Lombricomposta', '--'])
        self.mod9_motor_estado = self.treestore.append(self.modulo_9, ['Motor estado', '--'])
        self.mod9_motor_frecuencia = self.treestore.append(self.modulo_9, ['Dias encendido', '--'])
        self.mod9_humedad = self.treestore.append(self.modulo_9, ['Humedad', '--'])
        self.mod9_temperatura = self.treestore.append(self.modulo_9, ['Temperatura', '--'])
        
        self.modulo_10 = self.treestore.append(None, ['Acuaponia', '--'])
        self.mod10_temp_ambiente = self.treestore.append(self.modulo_10, ['Temperatura ambiente', '--'])
        self.mod10_temp_agua = self.treestore.append(self.modulo_10, ['Temperatura agua', '--'])
        self.mod10_ph = self.treestore.append(self.modulo_10, ['Ph', '-- '])
        self.mod10_dispensador_1a = self.treestore.append(self.modulo_10, ['Dispensador 1a', '--'])
        self.mod10_dispensador_1b = self.treestore.append(self.modulo_10, ['Dispensador 1b', '--'])
        self.mod10_dispensador_2a = self.treestore.append(self.modulo_10, ['Dispensador 2a', '--'])
        self.mod10_dispensador_2b = self.treestore.append(self.modulo_10, ['Dispensador 2b', '--'])
        self.mod10_dispensador_3a = self.treestore.append(self.modulo_10, ['Dispensador 3a', '--'])
        self.mod10_dispensador_3b = self.treestore.append(self.modulo_10, ['Dispensador 3b', '--'])
        self.mod10_bomba_1a = self.treestore.append(self.modulo_10, ['Bomba 1a', '--'])
        self.mod10_bomba_1b = self.treestore.append(self.modulo_10, ['Bomba 1b', '--'])
        self.mod10_bomba_1c = self.treestore.append(self.modulo_10, ['Bomba 1c', '--'])
        self.mod10_bomba_2a = self.treestore.append(self.modulo_10, ['Bomba 2a', '--'])
        self.mod10_bomba_2b = self.treestore.append(self.modulo_10, ['Bomba 2b', '--'])
        self.mod10_bomba_2c = self.treestore.append(self.modulo_10, ['Bomba 2c', '--'])
        
        self.modulo_11 = self.treestore.append(None, ['Destilador solar', '--'])
        self.mod11_temp_sol = self.treestore.append(self.modulo_11, ['Temperatura Sol', '--'])
        self.mod11_temp_lente = self.treestore.append(self.modulo_11, ['Temperatura Lente', '--'])
        self.mod11_temp_interna = self.treestore.append(self.modulo_11, ['Temperatura Interna', '--'])
        self.mod11_nivel_contenedor = self.treestore.append(self.modulo_11, ['Nivel contenedor', '--'])
        
        self.modulo_12 = self.treestore.append(None, ['Condensador atmosferico', '--'])
        self.mod12_temp_ambiente = self.treestore.append(self.modulo_12, ['Temperatura ambiente', '--'])
        self.mod12_temp_interior = self.treestore.append(self.modulo_12, ['Temperatura interior', '--'])
        self.mod12_temp_agua = self.treestore.append(self.modulo_12, ['Temperatura agua', '--'])
        self.mod12_humedad_1 = self.treestore.append(self.modulo_12, ['Humedad 1', '-- %'])
        self.mod12_humedad_2 = self.treestore.append(self.modulo_12, ['Humedad 2', '-- %'])
        self.mod12_ldr = self.treestore.append(self.modulo_12, ['LDR Estado', '--'])
        self.mod12_motor = self.treestore.append(self.modulo_12, ['Motor', '--'])
        self.mod12_nivel = self.treestore.append(self.modulo_12, ['Nivel de agua', '--'])
        
        self.modulo_13 = self.treestore.append(None, ['Agua de lluvia', '--'])
        self.mod13_nivel_1 = self.treestore.append(self.modulo_13, ['Nivel 1', '--'])
        self.mod13_nivel_2 = self.treestore.append(self.modulo_13, ['Nivel 2', '--'])
        self.mod13_nivel_3 = self.treestore.append(self.modulo_13, ['Nivel 3', '--'])
        self.mod13_nivel_4 = self.treestore.append(self.modulo_13, ['Nivel 4', '--'])
        self.mod13_nivel_5 = self.treestore.append(self.modulo_13, ['Nivel 5', '--'])
        self.mod13_nivel_6 = self.treestore.append(self.modulo_13, ['Nivel 6', '--'])
        self.mod13_bomba_1 = self.treestore.append(self.modulo_13, ['Bomba 1', '--'])
        self.mod13_bomba_2 = self.treestore.append(self.modulo_13, ['Bomba 2', '--'])
        
        self.modulo_14 = self.treestore.append(None, ['Autonomia de transporte', '--'])
        self.mod14_alternador = self.treestore.append(self.modulo_14, ['Contador alternador', '--'])
        
        self.modulo_15 = self.treestore.append(None, ['Enfriamiento por adsorcion', '--'])
        self.mod15_presion = self.treestore.append(self.modulo_15, ['Presion', '--'])
        self.mod15_presion_domo = self.treestore.append(self.modulo_15, ['Presion domo torre', '--'])
        self.mod15_temp_fria = self.treestore.append(self.modulo_15, ['Temperatura agua fria', '--'])
        self.mod15_temp_caliente = self.treestore.append(self.modulo_15, ['Temperatura agua caliente', '--'])
        self.mod15_temp_sal_caliente = self.treestore.append(self.modulo_15, ['Temperatura salida caliente', '--'])
        self.mod15_temp_tuberia = self.treestore.append(self.modulo_15, ['Temperatura tuberia', '--'])
        
    def cambiar_estado_tarjeta(self, estado):
        if estado == "Detectada":
            markup = "<span color='green'><b>" + estado + "</b></span>"
        else:
            markup = "<span color='red'><b>" + estado + "</b></span>"
        self.ltarjeta.set_markup(markup)
        
    def cambiar_estado_base_remota(self, estado):
        if estado == "Detectada":
            markup = "<span color='green'><b>" + estado + "</b></span>"
        elif estado == "Falló":
            markup = "<span color='red'><b>" + estado + "</b></span>"
        else:
            markup = "<b>" + estado + "</b>"
        self.lservidor.set_markup(markup)
        
    def cambiar_estado_base(self, estado):    
        if estado == "Conectada":
            markup = "<span color='green'><b>" + estado + "</b></span>"
        else:
            markup = "<span color='red'><b>" + estado + "</b></span>"
        self.lbase.set_markup(markup)
    
    def cambiar_estado_actividad(self, estado):    
        markup = "<span color='black'><b>" + estado + "</b></span>"
        self.lactividad.set_markup(markup)
    
    def ventana_cargada(self, widget, data=None):
        #print "Se ha cargado la ventana"
        #self.treeview.expand_all()
        pass
    
    
    def actualizar_modelo(self, trama):
        if trama[1] == "01":
            self.treestore.set(self.modulo_1, 1, "Activo")
            self.treestore.set(self.mod1_temp_mezcla, 1, trama[2])
            self.treestore.set(self.mod1_temp_reactor, 1, trama[3])
            self.treestore.set(self.mod1_nivel_reactor, 1, trama[4])
            self.treestore.set(self.mod1_nivel_deposito_gas, 1, trama[5])
            self.treestore.set(self.mod1_res_calentador_agua, 1, trama[6])
            self.treestore.set(self.mod1_motor_agitador_a, 1, trama[7])
            self.treestore.set(self.mod1_motor_agitador_b, 1, trama[8])
            self.treestore.set(self.mod1_motor_agitador_c, 1, trama[9])
            self.treestore.set(self.mod1_presion_gas, 1, trama[10])
        
        elif trama[1] == '02':
            self.treestore.set(self.modulo_2, 1, "Activo")
            self.treestore.set(self.mod2_presion_calderin, 1, trama[2] )
            self.treestore.set(self.mod2_presion_domo, 1, trama[3])
            self.treestore.set(self.mod2_presion_enchaquetado, 1, trama[4])
            self.treestore.set(self.mod2_temp_domo, 1, trama[5])
            self.treestore.set(self.mod2_temp_calderin, 1, trama[6])
            self.treestore.set(self.mod2_temp_enchaquetado, 1, trama[7])
            self.treestore.set(self.mod2_nivel_mezcla_calderin, 1, trama[8])
            self.treestore.set(self.mod2_nivel_almacenamiento, 1, trama[9])
            
        elif trama[1] == '03':
            self.treestore.set(self.modulo_3, 1, "Activo")
            self.treestore.set(self.mod3_temp_reactor, 1, trama[2])
            self.treestore.set(self.mod3_bomba_1, 1, trama[3])
            self.treestore.set(self.mod3_bomba_2, 1, trama[4])
            self.treestore.set(self.mod3_agitador_1a, 1, trama[5])
            self.treestore.set(self.mod3_agitador_1b, 1, trama[6])
            self.treestore.set(self.mod3_agitador_2a, 1, trama[7])
            self.treestore.set(self.mod3_agitador_2b, 1, trama[8])
            self.treestore.set(self.mod3_agitador_2c, 1, trama[9])
            self.treestore.set(self.mod3_res_calentador_estado, 1, trama[10])
            self.treestore.set(self.mod3_res_calentador_tiempo, 1, trama[11])
            
        elif trama[1] == "04":
            self.treestore.set(self.modulo_4, 1, "Activo")
            self.treestore.set(self.mod4_temp_agua_fria, 1, trama[2])
            self.treestore.set(self.mod4_temp_agua_caliente, 1, trama[3])
            self.treestore.set(self.mod4_temp_salida_agua_fria, 1, trama[4])
            self.treestore.set(self.mod4_temp_agua_caliente, 1, trama[5])
#            self.treestore.set(self.mod4_ldr1, 1, trama[6])
 #           self.treestore.set(self.mod4_ldr2, 1, trama[7])
  #          self.treestore.set(self.mod4_ldr3, 1, trama[8])
   #         self.treestore.set(self.mod4_posicion_calentador, 1, trama[9])
    #        self.treestore.set(self.mod4_motor_seguidor, 1, trama[10])
            
        elif trama[1] == "05":
            self.treestore.set(self.modulo_5, 1, "Activo")
            self.treestore.set(self.mod5_velocidad_viento, 1, trama[2])
            self.treestore.set(self.mod5_voltaje, 1, trama[3])
            self.treestore.set(self.mod5_potencia, 1, trama[4])
            self.treestore.set(self.mod5_rpm, 1, trama[5])
            
        elif trama[1] == "06":
            self.treestore.set(self.modulo_6, 1, "Activo")
            self.treestore.set(self.mod6_corriente, 1, trama[2])
            self.treestore.set(self.mod6_voltaje, 1, trama[3])
            self.treestore.set(self.mod6_rpm, 1, trama[4])
            
        elif trama[1] == "07":
            self.treestore.set(self.modulo_7, 1, "Activo")
            self.treestore.set(self.mod7_temp_caliente, 1, trama[2] )
            self.treestore.set(self.mod7_temp_fria, 1, trama[3] )
            self.treestore.set(self.mod7_rpm, 1, trama[4])
            self.treestore.set(self.mod7_presion, 1, trama[5])
            
        elif trama[1] == "08":
            self.treestore.set(self.modulo_8, 1, "Activo")
            self.treestore.set(self.mod8_nivel, 1, trama[2])
            self.treestore.set(self.mod8_rpm, 1, trama[3])
            self.treestore.set(self.mod8_presion, 1, trama[4])
        
        elif trama[1] == "09":
            self.treestore.set(self.modulo_9, 1, "Activo")
            self.treestore.set(self.mod9_motor_estado, 1, trama[2])
            self.treestore.set(self.mod9_motor_frecuencia, 1, trama[3])
            self.treestore.set(self.mod9_humedad, 1, trama[4])
            self.treestore.set(self.mod9_temperatura, 1, trama[5])
        
        elif trama[1] == "10":
            self.treestore.set(self.modulo_10, 1, "Activo")
            self.treestore.set(self.mod10_temp_ambiente, 1, trama[2])
            self.treestore.set(self.mod10_temp_agua, 1, trama[3])
            self.treestore.set(self.mod10_ph, 1, trama[4])
            self.treestore.set(self.mod10_dispensador_1a, 1, trama[5])
            self.treestore.set(self.mod10_dispensador_1b, 1, trama[6])
            self.treestore.set(self.mod10_dispensador_2a, 1, trama[7])
            self.treestore.set(self.mod10_dispensador_2b, 1, trama[8])
            self.treestore.set(self.mod10_dispensador_3a, 1, trama[9])
            self.treestore.set(self.mod10_dispensador_3b, 1, trama[10])
            self.treestore.set(self.mod10_bomba_1a, 1, trama[11])
            self.treestore.set(self.mod10_bomba_1b, 1, trama[12])
            self.treestore.set(self.mod10_bomba_1c, 1, trama[13])
            self.treestore.set(self.mod10_bomba_2a, 1, trama[14])
            self.treestore.set(self.mod10_bomba_2b, 1, trama[15])
            self.treestore.set(self.mod10_bomba_2c, 1, trama[16])
            
        elif trama[1] == "11":
            self.treestore.set(self.modulo_11, 1, "Activo")
            self.treestore.set(self.mod11_temp_sol, 1, trama[2])
            self.treestore.set(self.mod11_temp_lente, 1, trama[3])
            self.treestore.set(self.mod11_temp_interna, 1, trama[4])
            self.treestore.set(self.mod11_nivel_contenedor, 1, trama[5])
            
        elif trama[1] == "12":
            self.treestore.set(self.modulo_12, 1, "Activo")
            self.treestore.set(self.mod12_temp_ambiente, 1, trama[2])
            self.treestore.set(self.mod12_temp_interior, 1, trama[3])
            self.treestore.set(self.mod12_temp_agua, 1, trama[4])
            self.treestore.set(self.mod12_humedad_1, 1, trama[5])
            self.treestore.set(self.mod12_humedad_2, 1, trama[6])
            self.treestore.set(self.mod12_ldr, 1, trama[7])
            self.treestore.set(self.mod12_motor, 1, trama[8])
            self.treestore.set(self.mod12_nivel, 1, trama[9])
        
        elif trama[1] == "13":
            self.treestore.set(self.modulo_13, 1, "Activo")
            self.treestore.set(self.mod13_nivel_1, 1, trama[2])
            self.treestore.set(self.mod13_nivel_2, 1, trama[3])
            self.treestore.set(self.mod13_nivel_3, 1, trama[4])
            self.treestore.set(self.mod13_nivel_4, 1, trama[5])
            self.treestore.set(self.mod13_nivel_5, 1, trama[6])
            self.treestore.set(self.mod13_nivel_6, 1, trama[7])
            self.treestore.set(self.mod13_bomba_1, 1, trama[8])
            self.treestore.set(self.mod13_bomba_2, 1, trama[9])

            
        elif trama[1] == "14":
            self.treestore.set(self.modulo_14, 1, "Activo")
            self.treestore.set(self.mod14_alternador, 1, trama[2])
            
        elif trama[1] == "15":
            self.treestore.set(self.modulo_15, 1, "Activo")
            self.treestore.set(self.mod15_presion, 1, trama[2])
            self.treestore.set(self.mod15_presion_domo, 1, trama[3])
            self.treestore.set(self.mod15_temp_fria, 1, trama[4])
            self.treestore.set(self.mod15_temp_caliente, 1, trama[5])
            self.treestore.set(self.mod15_temp_sal_caliente, 1, trama[6])
            self.treestore.set(self.mod15_temp_tuberia, 1, trama[7])
        
    def main(self):
        gtk.main()
        
if __name__ == "__main__":
    g = gui(None)    
    g.main()
    
        
        
        
        
