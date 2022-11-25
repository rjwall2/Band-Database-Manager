--
--
-- drop table statements
--
--

drop table RECORD_LABEL cascade constraints;
drop table BAND cascade constraints;
drop table SOLD_MERCHANDISE_1 cascade constraints;
drop table SOLD_MERCHANDISE_2 cascade constraints;
drop table PAST_CONCERTS_1 cascade constraints;
drop table PAST_CONCERTS_2 cascade constraints;
drop table ALBUMS cascade constraints;
drop table SONGS cascade constraints;
drop table STREAMING_PLATFORM cascade constraints;
drop table BANDMEMBERS cascade constraints;
drop table VOCALIST cascade constraints;
drop table DRUMMER cascade constraints;
drop table GUITARIST cascade constraints;
drop table BASSIST cascade constraints;
drop table PIANIST cascade constraints;
drop table CONSISTS_OF cascade constraints;
drop table RELEASED_ON cascade constraints;
drop table PLAYED_AT cascade constraints;
drop table CONTAINS cascade constraints;

--
--
-- create table statements
--
--

CREATE TABLE Record_Label (
	RecordLabelName CHAR(20) PRIMARY KEY
);

CREATE TABLE Band (
	BandName CHAR(20) PRIMARY KEY,
	ChartsRating INTEGER,
	RecordLabel CHAR(20),
	FOREIGN KEY (RecordLabel) REFERENCES Record_Label(RecordLabelName) ON DELETE SET NULL
);

CREATE TABLE Sold_Merchandise_1 (
	MerchandiseType CHAR(10) PRIMARY KEY,
	Price INTEGER
);

CREATE TABLE Sold_Merchandise_2 (
	MerchandiseType CHAR(10),
	MerchandiseID INTEGER PRIMARY KEY,
    Band CHAR(20) NOT NULL,
    FOREIGN KEY (MerchandiseType) REFERENCES Sold_Merchandise_1(MerchandiseType) ON DELETE CASCADE,
    FOREIGN KEY (Band) REFERENCES Band(BandName) ON DELETE CASCADE
);

CREATE TABLE Past_Concerts_1 (
	TicketsSold INTEGER,
	PricePerTicket INTEGER,
	ConcertRevenue INTEGER,
	PRIMARY KEY (TicketsSold, PricePerTicket)
);

CREATE TABLE Past_Concerts_2 (
	DatePlayed INTEGER,
	Time INTEGER,
	Venue CHAR(30),
	BandPlayed CHAR(20) NOT NULL,
	TicketsSold INTEGER,
	PricePerTicket INTEGER,
	PRIMARY KEY (DatePlayed, Time, Venue),
	FOREIGN KEY (BandPlayed) REFERENCES Band(BandName) ON DELETE CASCADE,
	FOREIGN KEY (TicketsSold, PricePerTicket) REFERENCES Past_Concerts_1(TicketsSold, PricePerTicket) ON DELETE CASCADE
);

CREATE TABLE Albums (
	AlbumName CHAR(20) PRIMARY KEY, 
	ReleaseDate INTEGER,
	TotalSalesRevenue INTEGER,
	Band CHAR(20) NOT NULL, 
	FOREIGN KEY(Band) REFERENCES Band(BandName) ON DELETE CASCADE
);

CREATE TABLE Songs(
	SongName CHAR(30), 
	ReleaseDate INTEGER,
	TotalSalesRevenue INTEGER, 
	Band CHAR(20),
	Album CHAR(20), 
	PRIMARY KEY (SongName, Band),
	FOREIGN KEY (Band) REFERENCES Band(BandName) ON DELETE CASCADE,
	FOREIGN KEY (Album) REFERENCES Albums(AlbumName) ON DELETE SET NULL
);

CREATE TABLE Streaming_Platform( 
	StreamingPlatformName CHAR(20) PRIMARY KEY,
	RevenuePerStream DECIMAL(5,4)
);

CREATE TABLE BandMembers (
	BandMemberName CHAR(25),
	BirthDate INTEGER,
	PRIMARY KEY (BandMemberName, BirthDate)
);

CREATE TABLE Vocalist (
	BandMemberName CHAR(25),
	BirthDate INTEGER,
	PRIMARY KEY (BandMemberName, BirthDate),
	FOREIGN KEY (BandMemberName, BirthDate) REFERENCES BandMembers(BandMemberName, BirthDate) ON DELETE CASCADE
);

CREATE TABLE Drummer (
	BandMemberName CHAR(25),
	BirthDate INTEGER,
	PRIMARY KEY (BandMemberName, BirthDate),
	FOREIGN KEY (BandMemberName, BirthDate) REFERENCES BandMembers(BandMemberName, BirthDate) ON DELETE CASCADE
);

CREATE TABLE Guitarist (
	BandMemberName CHAR(25),
	BirthDate INTEGER,
	PRIMARY KEY (BandMemberName, BirthDate),
	FOREIGN KEY (BandMemberName, BirthDate) REFERENCES BandMembers(BandMemberName, BirthDate) ON DELETE CASCADE
);

CREATE TABLE Bassist (
	BandMemberName CHAR(25),
	BirthDate INTEGER,
	PRIMARY KEY (BandMemberName, BirthDate),
	FOREIGN KEY (BandMemberName, BirthDate) REFERENCES BandMembers(BandMemberName, BirthDate) ON DELETE CASCADE
);

CREATE TABLE Pianist (
	BandMemberName CHAR(25),
	BirthDate INTEGER,
	PRIMARY KEY (BandMemberName, BirthDate),
	FOREIGN KEY (BandMemberName, BirthDate) REFERENCES BandMembers(BandMemberName, BirthDate) ON DELETE CASCADE
);

CREATE TABLE Consists_Of (
	Band CHAR(20),
	BandMemberName CHAR(25),
	BandMemberBirthDate INTEGER,
	PRIMARY KEY (Band, BandMemberName, BandMemberBirthDate),
	FOREIGN KEY (Band) REFERENCES Band(BandName) ON DELETE CASCADE,
	FOREIGN KEY (BandMemberName, BandMemberBirthDate) REFERENCES BandMembers(BandMemberName, BirthDate) ON DELETE CASCADE
);

CREATE TABLE Released_On(
	NumberOfStreams INTEGER,
	SongName CHAR(30),
	BandName CHAR(20),
	StreamingPlatform CHAR(20),
	PRIMARY KEY (SongName, BandName, StreamingPlatform),
	FOREIGN KEY (SongName, BandName) REFERENCES Songs(SongName,Band) ON DELETE CASCADE,
	FOREIGN KEY (StreamingPlatform) REFERENCES Streaming_Platform(StreamingPlatformName) ON DELETE CASCADE
);
/*Need a participation constraint assertion on Streaming_Platform*/

CREATE TABLE Played_At(
	DatePlayed INTEGER,
	Time INTEGER,
	Venue CHAR(30),
	SongName CHAR(30),
	BandName CHAR(20),
	PRIMARY KEY (DatePlayed, Time, Venue, SongName, BandName),
	FOREIGN KEY (SongName, BandName) REFERENCES Songs(SongName,Band) ON DELETE CASCADE,
	FOREIGN KEY (DatePlayed, Time, Venue) REFERENCES Past_Concerts_2(DatePlayed, Time, Venue) ON DELETE CASCADE
); 
/*Need a participation constraint assertion on Past_Concerts_2*/

CREATE TABLE Contains (
	AlbumName CHAR(20),
	SongName CHAR(30),
	BandName CHAR(20),
	PRIMARY KEY (AlbumName, SongName, BandName),
	FOREIGN KEY (AlbumName) REFERENCES Albums (AlbumName) ON DELETE CASCADE,
	FOREIGN KEY (SongName, BandName) REFERENCES Songs(SongName,Band) ON DELETE CASCADE
);
/*Need a participation constraint assertion on Albums*/ 

--
--
-- insert statements
--
--

INSERT INTO Record_Label(RecordLabelName) VALUES ('Atlantic Records');

INSERT INTO Record_Label(RecordLabelName) VALUES ('EMI');

INSERT INTO Record_Label(RecordLabelName) VALUES ('Apple Records');

INSERT INTO Record_Label(RecordLabelName) VALUES ('Warner Records');

INSERT INTO Record_Label(RecordLabelName) VALUES ('Interscope Records');


INSERT INTO Band(BandName, ChartsRating, RecordLabel) VALUES ('AC/DC', 65, 'Atlantic Records');

INSERT INTO Band(BandName, ChartsRating, RecordLabel) VALUES ('Queen', 57, 'EMI');

INSERT INTO Band(BandName, ChartsRating, RecordLabel) VALUES ('The Beatles', 80, 'Apple Records');

INSERT INTO Band(BandName, ChartsRating, RecordLabel) VALUES ('Fleetwood Mac', 20, 'Warner Records');

INSERT INTO Band(BandName, ChartsRating, RecordLabel) VALUES ('Imagine Dragons', 28, 'Interscope Records');

INSERT INTO Band(BandName, ChartsRating, RecordLabel) VALUES ('One Republic', 26, 'Interscope Records');


INSERT INTO Sold_Merchandise_1(MerchandiseType, Price) VALUES ('Hoodie', 59);

INSERT INTO Sold_Merchandise_1(MerchandiseType, Price) VALUES ('T-Shirt', 30);

INSERT INTO Sold_Merchandise_1(MerchandiseType, Price) VALUES ('Poster', 10);

INSERT INTO Sold_Merchandise_1(MerchandiseType, Price) VALUES ('Vinyl', 23);

INSERT INTO Sold_Merchandise_1(MerchandiseType, Price) VALUES ('CD', 22);


INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('Hoodie', 14, 'AC/DC');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('Poster', 29, 'AC/DC');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('T-Shirt', 1002, 'Queen');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('Poster', 1003, 'Queen');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('Vinyl', 1004, 'Queen');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('T-Shirt', 2054, 'The Beatles');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('Vinyl', 2055, 'The Beatles');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('T-Shirt', 3011, 'Fleetwood Mac');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('Hoodie', 4225, 'Imagine Dragons');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('Poster', 4222, 'Imagine Dragons');

INSERT INTO Sold_Merchandise_2(MerchandiseType, MerchandiseID, Band) VALUES ('CD', 5008, 'One Republic');


INSERT INTO Past_Concerts_1(TicketsSold, PricePerTicket, ConcertRevenue) VALUES (19223, 100, 1922300);

INSERT INTO Past_Concerts_1(TicketsSold, PricePerTicket, ConcertRevenue) VALUES (20000, 129, 2580000);

INSERT INTO Past_Concerts_1(TicketsSold, PricePerTicket, ConcertRevenue) VALUES (20000, 119, 2380000);

INSERT INTO Past_Concerts_1(TicketsSold, PricePerTicket, ConcertRevenue) VALUES (5272, 140, 738080);

INSERT INTO Past_Concerts_1(TicketsSold, PricePerTicket, ConcertRevenue) VALUES (5200, 50, 260000);

INSERT INTO Past_Concerts_1(TicketsSold, PricePerTicket, ConcertRevenue) VALUES (18533, 75, 1389975);

INSERT INTO Past_Concerts_1(TicketsSold, PricePerTicket, ConcertRevenue) VALUES (6008, 70, 420560);

INSERT INTO Past_Concerts_1(TicketsSold, PricePerTicket, ConcertRevenue) VALUES (5724, 70, 400680);



INSERT INTO Past_Concerts_2(DatePlayed, Time, Venue, BandPlayed, TicketsSold, PricePerTicket) VALUES (21062013, 1900, 'Rogers Arena', 'AC/DC', 19223, 100);

INSERT INTO Past_Concerts_2(DatePlayed, Time, Venue, BandPlayed, TicketsSold, PricePerTicket) VALUES (04072015, 1830, 'O2 Arena', 'Queen', 20000, 129);

INSERT INTO Past_Concerts_2(DatePlayed, Time, Venue, BandPlayed, TicketsSold, PricePerTicket) VALUES (16082007, 2000, 'The Gorge Amphitheater', 'The Beatles', 20000, 119);

INSERT INTO Past_Concerts_2(DatePlayed, Time, Venue, BandPlayed, TicketsSold, PricePerTicket) VALUES (06112009, 1930, 'Royal Albert Hall', 'The Beatles', 5272, 140);

INSERT INTO Past_Concerts_2(DatePlayed, Time, Venue, BandPlayed, TicketsSold, PricePerTicket) VALUES (20122018, 1800, 'Royal Albert Hall', 'Fleetwood Mac', 5200, 50);

INSERT INTO Past_Concerts_2(DatePlayed, Time, Venue, BandPlayed, TicketsSold, PricePerTicket) VALUES (09012022, 1800, 'O2 Arena', 'Imagine Dragons', 18533, 75);

INSERT INTO Past_Concerts_2(DatePlayed, Time, Venue, BandPlayed, TicketsSold, PricePerTicket) VALUES (09062018, 1800, 'PNE Amphitheater', 'Imagine Dragons', 6008, 70);

INSERT INTO Past_Concerts_2(DatePlayed, Time, Venue, BandPlayed, TicketsSold, PricePerTicket) VALUES (08062018, 1800, 'PNE Amphitheater', 'One Republic', 5724, 70);


INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Highway to Hell', 27071979, 1400000, 'AC/DC');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Iron Man 2', 19042010, 200000, 'AC/DC');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Back To Black', 25071980, 1000000, 'AC/DC');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('A Night at the Opera', 12121975, 9000000, 'Queen');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('News of the World', 28101977, 1800000, 'Queen');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Abbey Road', 05071969, 5000000, 'The Beatles');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Revolver', 05081966, 200000, 'The Beatles');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Help!', 06081965, 200000, 'The Beatles');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Rumours', 11041977, 850000, 'Fleetwood Mac');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Tusk', 12101979, 54321, 'Fleetwood Mac');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Night Visions', 10082012, 4000000, 'Imagine Dragons');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Waking Up', 15022009, 300500, 'One Republic');

INSERT INTO Albums(AlbumName, ReleaseDate, TotalSalesRevenue, Band) VALUES ('Human', 27082021, 95000, 'One Republic');


INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Walk All Over You', 27071979, 180000, 'AC/DC', 'Highway to Hell');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Guns For Hire', 19042010, 6000, 'AC/DC', 'Iron Man 2');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Hell Bells', 25071980, 33333, 'AC/DC', 'Back To Black');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Bohemian Rhapsody', 12121975, 7654321, 'Queen', 'A Night at the Opera');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('We Will Rock You', 28101977, 250000, 'Queen', 'News of the World');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Face It Alone', 16081985, 3000, 'Queen', NULL);

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Here Comes The Sun', 05071969, 2222222, 'The Beatles', 'Abbey Road');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Taxman', 05081966, 45000, 'The Beatles', 'Revolver');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Another Girl', 06081965, 27500, 'The Beatles', 'Help!');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('The Chain', 11041977, 111111, 'Fleetwood Mac', 'Rumours');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Storms', 12101979, 4000, 'Fleetwood Mac', 'Tusk');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Radioactive', 10082012, 1650000, 'Imagine Dragons', 'Night Visions');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Good Life', 15022009, 75000, 'One Republic', 'Waking Up');

INSERT INTO Songs(SongName, ReleaseDate, TotalSalesRevenue, Band, Album) VALUES ('Someday', 27082021, 5555, 'One Republic', 'Human');


INSERT INTO Streaming_Platform(StreamingPlatformName, RevenuePerStream) VALUES ('Youtube Music', 0.0020);

INSERT INTO Streaming_Platform(StreamingPlatformName, RevenuePerStream) VALUES ('Apple Music', 0.0010);

INSERT INTO Streaming_Platform(StreamingPlatformName, RevenuePerStream) VALUES ('Spotify', 0.0025);

INSERT INTO Streaming_Platform(StreamingPlatformName, RevenuePerStream) VALUES ('iHeartRadio', 0.0010);

INSERT INTO Streaming_Platform(StreamingPlatformName, RevenuePerStream) VALUES ('Amazon Music', 0.0015);


INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Chris Slade', 30101946);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Freddie Mercury', 05091946);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('John Lennon', 09101940);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Lindsey Buckingham', 03101949);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Ben McKee', 07041985);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Ryan Tedder', 26061979);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Paul McCartney', 18061942);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Mick Fleetwood', 24061947);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Phil Rudd', 19051954);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Ringo Starr', 07071940);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Daniel Platzman', 28091986);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Brian May', 19071947);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Brent Kutzle', 03081985);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Cliff Williams', 14121949);

INSERT INTO BandMembers(BandMemberName, BirthDate) VALUES ('Christine McVie', 12071943);


INSERT INTO Vocalist(BandMemberName, BirthDate) VALUES ('Freddie Mercury', 05091946);

INSERT INTO Vocalist(BandMemberName, BirthDate) VALUES ('John Lennon', 09101940);

INSERT INTO Vocalist(BandMemberName, BirthDate) VALUES ('Ryan Tedder', 26061979);

INSERT INTO Vocalist(BandMemberName, BirthDate) VALUES ('Paul McCartney', 18061942);

INSERT INTO Vocalist(BandMemberName, BirthDate) VALUES ('Lindsey Buckingham', 03101949);


INSERT INTO Drummer(BandMemberName, BirthDate) VALUES ('Chris Slade', 30101946);

INSERT INTO Drummer(BandMemberName, BirthDate) VALUES ('Mick Fleetwood', 24061947);

INSERT INTO Drummer(BandMemberName, BirthDate) VALUES ('Phil Rudd', 19051954);

INSERT INTO Drummer(BandMemberName, BirthDate) VALUES ('Ringo Starr', 07071940);

INSERT INTO Drummer(BandMemberName, BirthDate) VALUES ('Daniel Platzman', 28091986);


INSERT INTO Guitarist(BandMemberName, BirthDate) VALUES ('John Lennon', 09101940);

INSERT INTO Guitarist(BandMemberName, BirthDate) VALUES ('Lindsey Buckingham', 03101949);

INSERT INTO Guitarist(BandMemberName, BirthDate) VALUES ('Brian May', 19071947);

INSERT INTO Guitarist(BandMemberName, BirthDate) VALUES ('Ryan Tedder', 26061979);

INSERT INTO Guitarist(BandMemberName, BirthDate) VALUES ('Daniel Platzman', 28091986);


INSERT INTO Bassist(BandMemberName, BirthDate) VALUES ('Ben McKee', 07041985);

INSERT INTO Bassist(BandMemberName, BirthDate) VALUES ('Paul McCartney', 18061942);

INSERT INTO Bassist(BandMemberName, BirthDate) VALUES ('Brent Kutzle', 03081985);

INSERT INTO Bassist(BandMemberName, BirthDate) VALUES ('Cliff Williams', 14121949);

INSERT INTO Bassist(BandMemberName, BirthDate) VALUES ('Ryan Tedder', 26061979);


INSERT INTO Pianist(BandMemberName, BirthDate) VALUES ('Ryan Tedder', 26061979);

INSERT INTO Pianist(BandMemberName, BirthDate) VALUES ('Freddie Mercury', 05091946);

INSERT INTO Pianist(BandMemberName, BirthDate) VALUES ('Ben McKee', 07041985);

INSERT INTO Pianist(BandMemberName, BirthDate) VALUES ('John Lennon', 09101940);

INSERT INTO Pianist(BandMemberName, BirthDate) VALUES ('Christine McVie', 12071943);


INSERT INTO Consists_Of(Band, BandMemberName, BandMemberBirthDate) VALUES ('AC/DC', 'Chris Slade', 30101946);

INSERT INTO Consists_Of(Band, BandMemberName, BandMemberBirthDate) VALUES ('Queen', 'Freddie Mercury', 05091946);

INSERT INTO Consists_Of(Band, BandMemberName, BandMemberBirthDate) VALUES ('The Beatles', 'John Lennon', 09101940);

INSERT INTO Consists_Of(Band, BandMemberName, BandMemberBirthDate) VALUES ('Fleetwood Mac', 'Lindsey Buckingham', 03101949);

INSERT INTO Consists_Of(Band, BandMemberName, BandMemberBirthDate) VALUES ('Imagine Dragons', 'Ben McKee', 07041985);

INSERT INTO Consists_Of(Band, BandMemberName, BandMemberBirthDate) VALUES ('One Republic', 'Ryan Tedder', 26061979);


INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (1000000000, 'Bohemian Rhapsody', 'Queen', 'Spotify');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (2000000000, 'Bohemian Rhapsody', 'Queen', 'Amazon Music');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (3000000000, 'Bohemian Rhapsody', 'Queen', 'Apple Music');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (4000000000, 'Bohemian Rhapsody', 'Queen', 'iHeartRadio');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (5000000000, 'Bohemian Rhapsody', 'Queen', 'Youtube Music');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (700938212, 'Here Comes The Sun', 'The Beatles', 'Spotify');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (700, 'Here Comes The Sun', 'The Beatles', 'Amazon Music');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (7009, 'Here Comes The Sun', 'The Beatles', 'Apple Music');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (70093, 'Here Comes The Sun', 'The Beatles', 'iHeartRadio');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (700938, 'Here Comes The Sun', 'The Beatles', 'Youtube Music');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (1000000, 'The Chain', 'Fleetwood Mac', 'Spotify');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (1571220, 'The Chain', 'Fleetwood Mac', 'Amazon Music');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (1300086234, 'Radioactive', 'Imagine Dragons', 'iHeartRadio');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (200865412, 'Good Life', 'One Republic', 'Spotify');

INSERT INTO Released_On(NumberOfStreams, SongName, BandName, StreamingPlatform) VALUES (200000, 'Good Life', 'One Republic', 'Youtube Music');


INSERT INTO Played_At(DatePlayed, Time, Venue, SongName, BandName) VALUES (21062013, 1900, 'Rogers Arena', 'Walk All Over You', 'AC/DC');

INSERT INTO Played_At(DatePlayed, Time, Venue, SongName, BandName) VALUES (04072015, 1830, 'O2 Arena', 'Bohemian Rhapsody', 'Queen');

INSERT INTO Played_At(DatePlayed, Time, Venue, SongName, BandName) VALUES (16082007, 2000, 'The Gorge Amphitheater', 'Here Comes The Sun', 'The Beatles');

INSERT INTO Played_At(DatePlayed, Time, Venue, SongName, BandName) VALUES (20122018, 1800, 'Royal Albert Hall', 'The Chain', 'Fleetwood Mac');

INSERT INTO Played_At(DatePlayed, Time, Venue, SongName, BandName) VALUES (09012022, 1800, 'O2 Arena', 'Radioactive', 'Imagine Dragons');

INSERT INTO Played_At(DatePlayed, Time, Venue, SongName, BandName) VALUES (08062018, 1800, 'PNE Amphitheater', 'Good Life', 'One Republic');


INSERT INTO Contains(AlbumName, SongName, BandName) VALUES ('Highway to Hell', 'Walk All Over You', 'AC/DC');

INSERT INTO Contains(AlbumName, SongName, BandName) VALUES ('A Night at the Opera', 'Bohemian Rhapsody', 'Queen');

INSERT INTO Contains(AlbumName, SongName, BandName) VALUES ('Abbey Road', 'Here Comes The Sun', 'The Beatles');

INSERT INTO Contains(AlbumName, SongName, BandName) VALUES ('Rumours', 'The Chain', 'Fleetwood Mac');

INSERT INTO Contains(AlbumName, SongName, BandName) VALUES ('Night Visions', 'Radioactive', 'Imagine Dragons');

INSERT INTO Contains(AlbumName, SongName, BandName) VALUES ('Waking Up', 'Good Life', 'One Republic'); 