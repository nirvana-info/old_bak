'''
Created on 2010-11-3

@author: Administrator
'''
import Selection

class SmartSearch(TestBase):
    '''
    classdocs
    '''
    def SmartSearch_Seachcategories(self):
        Selection.smartsearch("Universal Air Filter Accessories")
    
    def SmartSearch_Seachbrands(self):
        Selection.smartsearch("Air Filter")
    
    def SmartSearch_SeachYMMbrands(self):
        Selection.smartsearch("air filter  2010")
        
    def SmartSearch_SeachYMMCategories(self):
        Selection.smartsearch("Universal Air Filter Accessories 2009")