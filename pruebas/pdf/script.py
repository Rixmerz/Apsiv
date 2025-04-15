# script.py

from reportlab.lib.pagesizes import letter
from reportlab.pdfgen import canvas

def generar_pdf(datos):
    # Datos recibidos desde PHP
    nombre = datos['nombre']
    cantidad = datos['cantidad']
    
    # Generar documento PDF
    c = canvas.Canvas("documento.pdf", pagesize=letter)
    c.drawString(100, 750, "Nombre: " + nombre)
    c.drawString(100, 730, "Cantidad: " + cantidad)
    c.save()
