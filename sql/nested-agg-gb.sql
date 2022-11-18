-- Find the total sales revenue from albums for each band 
-- where the total sales revenue is greater than the 
-- average sales revenue across all band albums

SELECT      Band, SUM(TotalSalesRevenue)
FROM        Albums
GROUP BY    Band
HAVING      SUM(TotalSalesRevenue) > (  SELECT AVG(TotalSalesRevenue)
                                        FROM Albums);