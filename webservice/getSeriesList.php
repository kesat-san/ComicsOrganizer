<?php
main();
    function main()
    {
        $dbFile = "sqlite:maindb.sqlite";
        $fname="maindb.sqlite";
        if (!file_exists($fname))
        {
            create_database($dbFile);
            addSampleData($dbFile);
        }
        sendSeriesList($dbFile);
    }
    function sendSeriesList($file)
    {
        $dbhandle = new PDO($file);
        $sth = $dbhandle->prepare("select id, SeriesName from SeriesList");
        $sth->execute();
        $result=$sth->fetchAll(PDO::FETCH_ASSOC);
        //echo $result;
        
        echo json_encode($result);
        
    }
    function addSampleData($file)
    {
        try
        {
            $dbhandle = new PDO($file);
            $stm = "insert into SeriesList (SeriesName)
                    values ('Batman')";
            $dbhandle->exec($stm);
            $stm = "insert into SeriesList (SeriesName)
                    values ('Superman')";
            $dbhandle->exec($stm);
            $stm = "insert into SeriesList (SeriesName)
                    values ('Teen Titans')";
            $dbhandle->exec($stm);
            $dbhandle = NULL;
        }
        catch (PDOException $e)
        {
            print $e->getMessage();
        }
    }
    function create_database($file)
    {
        $dbhandle = new PDO($file);
        $stm = "create table SeriesList
                (id integer primary key,
                SeriesName varchar(100))";
        $dbhandle->exec($stm);
        $stm = "create table OwnedComics
                (SeriesID integer,
                Title varchar(100),
                Subtitle varchar(100),
                Volume varchar(50),
                PurchasePrice real,
                PurchaseLocation varchar(200))";
        $dbhandle->exec($stm);       
        $dbhandle = NULL;
    }
?>