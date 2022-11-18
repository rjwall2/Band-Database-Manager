--Show every bands revenue from their top grossing album

SELECT Band, MAX(TotalSalesRevenue)
FROM Albums
GROUP BY Band;