'''
Created on 2010-10-13

@author: christie.duan
'''
import time


def my_wait_element(self, element, waittime): 
    for i in range(0, waittime):
        if self.selenium.is_element_present(element) == True :
            return True
        else :
            time.sleep(1)
    return False

def my_wait_title(self,text):
    for i in range(0,30):
        if self.selenium.get_title().find(text)<0:
            time.sleep(1)
    return False

def Wait_element_appears(self,element, waittime):
    for i in range (0, waittime):
        if self.selenium.is_element_present(element)==True:
            return True
        else:
            time.sleep(1)
    return False



