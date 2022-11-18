-- Find the total sales in sold merchandise 
-- for each band where the total sales is greater 
-- than the average sales across all bands

-- SELECT      sm2_1.Band, SUM(Price), AVG(Price)
-- FROM        Sold_Merchandise_1 sm1_1, Sold_Merchandise_2 sm2_1
-- WHERE       sm1_1.MerchandiseType = sm2_1.MerchandiseType
-- GROUP BY    sm2_1.Band
-- HAVING      SUM(Price) > (  SELECT AVG(Price) 
--                             FROM Sold_Merchandise_1 sm1_2, Sold_Merchandise_2 sm2_2
--                             WHERE sm1_2.MerchandiseType = sm2_2.MerchandiseType);

-- Find the total sales revenue of albums for each band 
-- where the total sales revenue is greater than the 
-- average sales revenue across all band albums

SELECT      Band, SUM(TotalSalesRevenue)
FROM        Albums
GROUP BY    Band
HAVING      SUM(TotalSalesRevenue) > (  SELECT AVG(TotalSalesRevenue)
                                        FROM Albums);