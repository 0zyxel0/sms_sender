import MySQLdb,time,datetime,serial

#indicate your COMPORT
usbport = 'COM8'

ser = serial.Serial(usbport, 9600, timeout = 1000)
conn = MySQLdb.connect(host="127.0.0.1",    # your host, usually localhost
                     user="root",         # your username
                     passwd="",  # your password
                     db="tapper_db")        # name of the data base


x = conn.cursor()
count=0;
gate_id = 'GTONE'
tryText = '';


def saveToDatabase(a,b,c):
      x.execute("""INSERT into gate_history (card_id,createdate,gate_id) values(%s,%s,%s)""" ,(a,b,c))
      conn.commit()
      print "Successfully Inserted Values to Database : Card Id :"+a+", Time : "+b+ ", Gate:"+c+ "."
      
while count != 1:
      try:
            tryText = ser.readline(44);
            convertToStr =str(tryText[33:]);
            clean = convertToStr.rstrip('\r');
            if clean.strip():
                  timestamp = datetime.datetime.utcnow().strftime('%Y-%m-%d %H:%M:%S')
                  saveToDatabase(clean,timestamp,gate_id)
                  timestamp = None;
            else:
                  print 'Try Scanning Again..'
            
      except:
            print "failed"
            conn.rollback()
      

