'''
Created on 2010-10-11
@author: christie.duan
#'''

import unittest
import Appobjects.HTMLTestRunner as HTMLTestRunner
import TCSuites


if __name__ == "__main__":
    fp = file('my_report.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(TCSuites.MoreSubCategoriesTest())
    
    
