--Returns songs never performed by a specified band in concert

SELECT s1.SongName
FROM Songs s1
WHERE s1.Band = [Inputted_Band] and s1.SongName NOT IN ( SELECT s2.SongName FROM Songs s2, Played_At pa WHERE pa.BandName = s2.Band and pa.SongName = s2.SongName);