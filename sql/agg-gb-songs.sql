--Show every bands revenue from their top grossing song

SELECT Band, MAX(TotalSalesRevenue)
FROM Songs
GROUP BY Band;