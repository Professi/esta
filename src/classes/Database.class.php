	 <?php
	
	include_once("../inc/config/db.php");
	
	class Database {
	
	    public function dbConnect() {
	        $db = mysqli_connect(HOST, USERDB, PASSWORD, DB);
	        if (mysqli_connect_error()) {
	            //   self::failure(false, $this->sql, __FILE__, __FUNCTION__, __LINE__,false,mysqli_connect_error());
	            $db = false;
	        }
	        $this->database = $db;
	    }
	
	    /*
	     * Name: dbClose
	     * Autor:Christian Ehringfeld
	     * Funktion: Schließt die Datenbank und gibt False zurück wenn ein Fehler auftritt.
	     */
	
	    public function dbClose() {
	        $db = $this->database;
	        if ($db != false) {
	            @mysqli_close($db);
	        }
	    }
	
	    /*
	     * Name: failure(Ergebnis der DB Abfrage, SQL Query, Datei(name), Funktion, Zeile des Fehlers, eventuell DBLink, Fehler) 
	     * Autor:Christian Ehringfeld
	     * Funktion: Fehlermeldung sofern ein MySQL Fehler aufgetreten ist.
	     * Gibt true oder false zurück
	     */
	
	    public function failure($result, $sql, $data, $function, $line, $db = false, $connectError = "") {
	        $rc = false;
	            if (!$result) {
	                if(@mysqli_errno($db) != 1062) {
	                $datei = @fopen(MYSQL_LOG, "a+");
	                if($datei != false) {
	                $f_text = date(LOGDATE);
	                $f_text .= "SQL:" . $sql . ";\n";
	                if (!$db) {
	                    $f_text .= "Fehler:" . $connectError . ";";
	                } else {
	                    $f_text .= "Fehler:" . @mysqli_error($db) . ";";
	                    $f_text .= "Fehlercode:" . @mysqli_errno($db) . ";\n";
	                }
	                $f_text .= "Script:" . basename($data) . ";";
	                $f_text .= "Funktion:" . $function . ";";
	                $f_text .= "Zeile:" . $line . ";";
	                fputs($datei, $f_text);
	                fclose($datei);
	                $rc = true;
	        }} $rc = true;}
	        return $rc;
	    }
	    
	        public function incrementCounter($table, $column, $error = true) {
	        $this->sql = "UPDATE " . $table . " SET " . $column . "=" . $column . "+1 WHERE `date` =\"" . date(STATFORMAT) . "\";";
	        return self::queryInsert($error);
	    }
	    
	        /*
	     * Name: query 
	     * Autor:Christian Ehringfeld
	     * Funktion: Stellt die Datenbankabfrage des SQL Befehls einer vorherigen Methode
	     */
	
	    public function query() {
	        $rc = false;
	        $sql = $this->sql;
	        $db = $this->database;
	        $result = mysqli_query($db, $sql);
	        if (!self::failure($result, $sql, __FILE__, __FUNCTION__, __LINE__, $db)) {
	            while ($row[] = mysqli_fetch_array($result, MYSQLI_ASSOC));
	            $rc = true;
	            $this->result = $row;
	        }
	        return $rc;
	    }
	
	    /* Name: queryNum()
	     * Autor: Christian Ehringfeld
	     * Funktion: Numerisches Mehrdimensionale Datenbankabfrage
	     */
	
	    public function queryNum($withErrorLog = true) {
	        $rc = false;
	        $sql = $this->sql;
	        $db = $this->database;
	        $result = mysqli_query($db, $sql);
	        if ($withErrorLog && !self::failure($result, $sql, __FILE__, __FUNCTION__, __LINE__, $db)) {
	            if ($result != false) {
	                while ($row[] = mysqli_fetch_array($result));
	                $this->result = $row;
	            }
	            $rc = true;
	        } else {
	            if ($result != false) {
	                while ($row[] = mysqli_fetch_array($result));
	                $this->result = $row;
	            }
	            $rc = true;
	        }
	
	        return $rc;
	    }
	
	    /* Name: queryOneDim()
	     * Autor: Christian Ehringfeld
	     * Funktion: Datenbankabfrage die nur Numerisch Eindimensional ist, wurde speziell für die Vorschlagsliste geschrieben
	     */
	
	    public function queryOneDim() {
	        $rc = false;
	        $sql = $this->sql;
	        $db = $this->database;
	        $result = mysqli_query($db, $sql);
	        $row_set = array();
	        if (!self::failure($result, $sql, __FILE__, __FUNCTION__, __LINE__, $db)) {
	            while ($row = mysqli_fetch_array($result)) {
	                $row_set[] = stripslashes($row[0]);
	            }
	            $rc = true;
	            $this->result = $row_set;
	        }
	
	        return $rc;
	    }
	
	    /* Name: queryInsert()
	     * Autor: Christian Ehringfeld
	     * Funktion: Fügt etwas in die Datenbank ein
	     */
	
	    public function queryInsert($withErrorLog = true) {
	        $rc = false;
	        $result = mysqli_query($this->database, $this->sql);
	        if ($withErrorLog && !self::failure($result, $this->sql, __FILE__, __FUNCTION__, __LINE__, $this->database)) {
	            $rc = true;
	        }
	        return $rc;
	    }
	
	    /* Name: firstLineSQL(Sprache 1, Sprache 2, Sprache1_Sprache2)
	     * Autor: Christian Ehringfeld
	     * Funktion: Sollte die isAdmin Funktion true zurückgeben, so wird beim SQL Befehl auch die ID ausgelesen
	     */
	
	    public function firstLineSQL($lang1, $lang2, $lang, $count = 0) {
	        if (self::isAdmin() && $count != 1) {
	            $sql = "SELECT " . ID . ", " . $lang1 . ", " . $lang2 . " FROM " . $lang;
	        } else if ($count == 1) {
	            $sql = "SELECT COUNT(*) AS `anzahlErgebnisse` FROM " . $lang;
	        } else {
	            $sql = "SELECT " . $lang1 . ", " . $lang2 . " FROM " . $lang;
	        }
	        return $sql;
	    }
	    
	        /*
	     * Name: fastSearch
	     * Autor:Christian Ehringfeld
	     * Funktion: SQL Befehl für Schnellsuche
	     */
	
	    public function fastSearch() {
	        $lang1 = $this->lang1;
	        $lang2 = $this->lang2;
	        $lang = $this->lang;
	        $word = $this->word;
	        $db = $this->database;
	        $word = mysqli_real_escape_string($db, $word);
	        $word = trim($word);
	        $sql = " WHERE MATCH(" . $lang1 . ", " . $lang2 . ") AGAINST(\"$word\")";
	        $sqlLimit = " LIMIT " . (int) $this->offset . "," . (int) $this->limit . ";";
	        $sqlFLine = self::firstLineSQL($lang1, $lang2, $lang, 0);
	        $sqlCountLine = self::firstLineSQL($lang1, $lang2, $lang, 1);
	        $this->sql = $sqlFLine . $sql . $sqlLimit;
	        $this->countsql = $sqlCountLine . $sql;
	    }
	}
?>
	
