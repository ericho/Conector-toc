import smtplib
import email
import os
from email.MIMEMultipart import MIMEMultipart
from email.Utils import COMMASPACE
from email.MIMEBase import MIMEBase
from email.parser import Parser
import mimetypes
from datetime import datetime


class alarmas_email:

    def __init__(self, controlador):
        """ Clase que se encarga de validar alarmas y enviarla por email  """
        self.correo_desde = 'telemetriatoc@gmail.com'
        self.password = 'CIETOC06'
        self.enviar_a_correo = 'erich.cm@gmail.com'
        self.server = smtplib.SMTP()
        self.controlador = controlador
        self.correo_agua_de_lluvia = 'juscanga@gmail.com'
        self.alarmas_agua_de_lluvia = {'CisternaAP': False,
                                        'TinacoAP': False,
                                        'CisternaALL': False,
                                        'TinacoALL': False,
                                        'TinacoAJ': False,
                                        'CisternaAJ': False}
        self.filtro_alarmas = {'CisternaAP': 0,
                               'TinacoAP': 0,
                               'CisternaALL': 0,
                               'TinacoALL': 0,
                               'TinacoAJ': 0,
                               'CisternaAJ': 0}

    def conectar_smtp(self):
        self.server.connect('smtp.gmail.com', 587)
        self.server.ehlo()
        self.server.starttls()
        self.server.login(self.correo_desde, self.password)

    def desconectar_smtp(self):
        self.server.close()

    def enviar_alarma(self, titulo, texto, enviar_a):
        self.conectar_smtp()
        mensaje = "\From: %s\nTo: %s\nSubject: %s\n\n%s" % (self.correo_desde,
                                                                enviar_a,
                                                                titulo,
                                                                texto)
        self.server.sendmail(self.correo_desde, enviar_a, mensaje)
        print "Correo enviado"
        self.desconectar_smtp()

    def revisar_alarma_agua_de_lluvia(self, trama):
        fecha = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        if int(trama[2]) <= 30:
            if not self.alarmas_agua_de_lluvia['CisternaAP']:
                titulo = "Alarma Agua de Lluvia"
                mensaje = "Fecha %s\nCisterna AP por debajo del 30%%\n Valor = %s\n" % (fecha, trama[2])
                if self.filtro_alarmas['CisternaAP'] > 10:
                    self.alarmas_agua_de_lluvia['CisternaAP'] = True
                    self.enviar_alarma(titulo, mensaje,
                                        self.correo_agua_de_lluvia)
                    self.enviar_alarma(titulo, mensaje,
                                        self.enviar_a_correo)
                else:
                    self.filtro_alarmas['CisternaAP'] += 1
        elif int(trama[2]) > 30:
            self.alarmas_agua_de_lluvia['CisternaAP'] = False
            self.filtro_alarmas['CisternaAP'] = 0
        if int(trama[3]) <= 20:
            if not self.alarmas_agua_de_lluvia['TinacoAP']:
                titulo = "Alarma Agua de Lluvia"
                mensaje = "Fecha %s\nTinaco AP por debajo del 20%%\n Valor = %s\n" % (fecha, trama[3])
                if self.filtro_alarmas['TinacoAP'] > 10:
                    self.alarmas_agua_de_lluvia['TinacoAP'] = True
                    self.enviar_alarma(titulo, mensaje,
                                        self.correo_agua_de_lluvia)
                    self.enviar_alarma(titulo, mensaje,
                                        self.enviar_a_correo)
                else:
                    self.filtro_alarmas['TinacoAP'] += 1
        elif int(trama[3]) > 20:
            self.alarmas_agua_de_lluvia['TinacoAP'] = False
            self.filtro_alarmas['TinacoAP'] = 0
        if int(trama[4]) <= 15:
            if not self.alarmas_agua_de_lluvia['CisternaALL']:
                titulo = "Alarma Agua de Lluvia"
                mensaje = "Fecha %s\nCisterna Agua de Lluvia por debajo del 15%%\n Valor = %s\n" % (fecha, trama[4])
                if self.filtro_alarmas['CisternaALL'] > 10:
                    self.alarmas_agua_de_lluvia['CisternaALL'] = True
                    self.enviar_alarma(titulo, mensaje,
                                        self.correo_agua_de_lluvia)
                    self.enviar_alarma(titulo, mensaje,
                                        self.enviar_a_correo)
                else:
                    self.filtro_alarmas['CisternaALL'] += 1
        elif int(trama[4]) > 15:
            self.alarmas_agua_de_lluvia['CisternaALL'] = False
            self.filtro_alarmas['CisternaALL'] = 0
        if int(trama[5]) <= 10:
            if not self.alarmas_agua_de_lluvia['TinacoALL']:
                titulo = "Alarma Agua de Lluvia"
                mensaje = "Fecha %s \nTinaco Agua de lluvia por debajo del 10%% \n Valor = %s\n" % (fecha, trama[5])
                if self.filtro_alarmas['TinacoALL'] > 10:
                    self.alarmas_agua_de_lluvia['TinacoALL'] = True
                    self.enviar_alarma(titulo, mensaje,
                                        self.correo_agua_de_lluvia)
                    self.enviar_alarma(titulo, mensaje,
                                        self.enviar_a_correo)
                else:
                    self.filtro_alarmas['TinacoALL'] += 1
        elif int(trama[5]) > 10:
            self.alarmas_agua_de_lluvia['TinacoALL'] = False
            self.filtro_alarmas['TinacoALL'] = 0
        if int(trama[6]) >= 10 and int(trama[6]) <= 40:
            if not self.alarmas_agua_de_lluvia['TinacoAJ']:
                titulo = "Alarma Agua de Lluvia"
                mensaje = "Tinaco de Agua Jabonosa debajo del 40%"
                mensaje = "Fecha %s\nTinaco agua jabonosa por debajo del 40%%\n Valor = %s\n" % (fecha, trama[6])
                if self.filtro_alarmas['TinacoAJ'] > 10:
                    self.alarmas_agua_de_lluvia['TinacoAJ'] = True
                    self.enviar_alarma(titulo, mensaje,
                                        self.correo_agua_de_lluvia)
                    self.enviar_alarma(titulo, mensaje,
                                        self.enviar_a_correo)
                else:
                    self.filtro_alarmas['TinacoAJ'] += 1
        elif int(trama[6] > 40):
            self.alarmas_agua_de_lluvia['TinacoAJ'] = False
            self.filtro_alarmas['TinacoAJ'] = 0

if __name__ == "__main__":
    al = alarmas_email(None)
