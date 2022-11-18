--Finds the bands that are on all streaming platforms

Select BandName
From Band B
Where Not Exists
   ((Select S.StreamingPlatformName
   From Streaming_Platform S)
   Minus
       (Select r.StreamingPlatform
       From Released_On r
       where r.BandName = B.BandName));

