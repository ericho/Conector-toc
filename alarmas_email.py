import smtplib
import email
import os
from email.MIMEMultipart import MIMEMultipart
from email.Utils import COMMASPACE
from email.MIMEBase import MIMEBase
from email.parser import Parser
import mimetypes


class alarmas_email:

    def __init__(self, controlador):
        """ Clase que se encarga de validar alarmas y enviarla por email  """
        self.correo_desde = 'telemetriatoc@gmail.com'
        self.password = 'CIETOC06'
        self.enviar_a_correo = 'erich.cm@gmail.com'
        self.server = smtplib.SMTP()
        self.controlador = controlador
        self.correo_agua_de_lluvia = 'erich.cm@gmail.com'
        self.alarmas_agua_de_lluvia = {'CisternaAP':False, 'TinacoAP':False,
                                        'CisternaALL':False, 'TinacoALL':False,
                                        'TinacoAJ':False, 'CisternaAJ':False}


    def conectar_smtp(self):
        self.server.connect('smtp.gmail.com', 587)
        self.server.ehlo()
        self.server.starttls()
        self.server.login(self.correo_desde, self.password)

    def desconectar_smtp(self):
        self.server.close()

    def enviar_alarma(self, titulo, texto, enviar_a):
        self.conectar_smtp()
        mensaje = "\From: %s\nTo: %s\nSubject: %s\n\n%s "  % (self.correo_desde,
                                                                enviar_a,
                                                                titulo,
                                                                texto)
        self.server.sendmail(self.correo_desde, enviar_a, mensaje)
        print "Correo enviado"
        self.desconectar_smtp()

    def revisar_alarma_agua_de_lluvia(self, trama):
        if int(trama[2]) <= 30 and not self.alarmas_agua_de_lluvia['CisternaAP']:
            titulo = "Alarma Agua de Lluvia"
            mensaje = "Cisterna AP por debajo del 30%\n\n"
            self.alarmas_agua_de_lluvia['CisternaAP'] = True
            self.enviar_alarma(titulo, mensaje, self.correo_agua_de_lluvia)
        elif int(trama[2]) > 30 and self.alarmas_agua_de_lluvia['CisternaAP']:
            self.alarmas_agua_de_lluvia['CisternaAP'] = False
        if int(trama[3]) <= 20 and not self.alarmas_agua_de_lluvia['TinacoAP']:
            titulo = "Alarma Agua de Lluvia"
            mensaje = "Tinaco AP por debajo del 20%\n\n"
            self.alarmas_agua_de_lluvia['TinacoAP'] = True
            self.enviar_alarma(titulo, mensaje, self.correo_agua_de_lluvia)
        elif int(trama[3]) > 20 and self.alarmas_agua_de_lluvia['TinacoAP']:
            self.alarmas_agua_de_lluvia['CisternaAP'] = False
        if int(trama[4]) <= 15 and not self.alarmas_agua_de_lluvia['CisternaALL']:
            titulo = "Alarma Agua de Lluvia"
            mensaje = "Cisterna Agua de Lluvia por debajo del 15%"
            self.alarmas_agua_de_lluvia['CisternaALL'] = True
            self.enviar_alarma(titulo, mensaje, self.correo_agua_de_lluvia)
        elif int(trama[4]) > 15 and self.alarmas_agua_de_lluvia['CisternaALL']:
            self.alarmas_agua_de_lluvia['CisternaALL'] = False
        if int(trama[5]) <= 10:
            if not self.alarmas_agua_de_lluvia['TinacoALL']
                titulo = "Alarma Agua de Lluvia"
                mensaje = "Tinaco Agua de Lluvia por debajo del 10%"
                self.alarmas_agua_de_lluvia['TinacoALL'] = True
                self.enviar_alarma(titulo, mensaje, self.correo_agua_de_lluvia)
        elif int(trama[6]) > 10:
            self.alarmas_agua_de_lluvia['TinacoALL'] = False
        if int(trama[6]) >= 10 and int(trama[6]) <= 40 and not self.alarmas_agua_de_lluvia['TinacoAJ']:
            titulo = "Alarma Agua de Lluvia"
            mensaje = "Tinaco de Agua Jabonosa debajo del 40%"
            self.alarmas_agua_de_lluvia['TinacoAJ'] = True
            self.enviar_alarma(titulo, mensaje, self.correo_agua_de_lluvia)
        elif int(trama[6] > 40) and self.alarmas_agua_de_lluvia['TinacoAJ']:
            self.alarmas_agua_de_lluvia['TinacoAJ'] = False

if __name__ == "__main__":
    al = alarmas_email(None)
