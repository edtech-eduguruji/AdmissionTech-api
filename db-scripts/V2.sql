
CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `registrationNo` varchar(100) NOT NULL,
  `paymentId` varchar(500) NOT NULL,
  `TxnReferenceNo` varchar(50) NOT NULL,
  `BankReferenceNo` varchar(50) NOT NULL,
  `BankID` varchar(50) NOT NULL,
  `Bin` varchar(50) NOT NULL,
  `TxnAmount` varchar(50) NOT NULL,
  `TxnCode` varchar(50) NOT NULL,
  `TxnType` varchar(50) NOT NULL,
  `TxnDate` varchar(50) NOT NULL,
  `AuthStatusCode` int(10) NOT NULL,
  `AuthMsg` varchar(100) NOT NULL,
  `creationTime` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;



ALTER TABLE `merit_details` ADD `uploadExtraMark` VARCHAR(1000) NOT NULL AFTER `other`;