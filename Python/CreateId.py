#!/usr/bin/env/python2.7

import webbrowser
import time
import datetime
import serial
#indicate your COMPORT
usbport = 'COM7'
FrmScanner = serial.Serial(usbport, 9600, timeout = 5)


x=0;
while x != 1:
   try:
      tryText = FrmScanner.readline(44)
      convs =str(tryText[33:]);
      cleanStr = convs.rstrip('\r')
      print cleanStr
      x = 1;

   except:
      print "failed"













