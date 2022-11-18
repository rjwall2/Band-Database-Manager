--Return bands that have made over a specified amount of money from total concert revenue
--along with the total sum of concert revenue 

SELECT BandPlayed, SUM(ConcertRevenue)
FROM Past_Concerts_1 pc1, Past_Concerts_2 pc2
WHERE pc1.TicketsSold = pc2.TicketsSold and pc1.PricePerTicket = pc2.PricePerTicket
GROUP BY pc2.BandPlayed
HAVING SUM(ConcertRevenue) > [Inserted_Integer];