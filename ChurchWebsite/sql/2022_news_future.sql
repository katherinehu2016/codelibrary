create table ch_Sermon_News(
	news_id MEDIUMINT NOT NULL AUTO_INCREMENT,
	speaker varchar (500),
	title varchar(500),
	verse varchar (1000), 
	Room varchar (50),
	sort_order SMALLINT DEFAULT 2,
	PRIMARY KEY(news_id)

);

create table ch_SundaySchool_News(
	news_id MEDIUMINT NOT NULL AUTO_INCREMENT,
	speaker varchar (500),
	title varchar(500),
	verse varchar (1000), 
	Room varchar (50),
	sort_order SMALLINT DEFAULT 2,
	PRIMARY KEY(news_id)

);


