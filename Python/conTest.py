import MySQLdb

conn = MySQLdb.Connect(host="127.0.0.1",port=8899,user="root",passwd="",db="tapper_db")
Cursor = conn.cursor()
sql = "SELECT * FROM gate_history"
Cursor.execute(sql)
