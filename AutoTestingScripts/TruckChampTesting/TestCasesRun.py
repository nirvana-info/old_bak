'''
Created on 2010-10-11
@author: christie.duan
#'''

import unittest
import HTMLTestRunner
import TCSuites


if __name__ == "__main__":
    fp = file('my_report.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(TCSuites.SmokingTest()) ## .......... 
##    runner.run(TCSuites.MoreSubCategoriesTest()) ## ..EE..
##    runner.run(TCSuites.MoreSeriesTest()) ## ...... 
##    runner.run(TCSuites.ZeroOrOneSeriesTest()) ##....
##    runner.run(TCSuites.ZeroOrOneCatesTest()) ##....E.  
##    runner.run(TCSuites.DiscountOrderTest()) ## .....

    
