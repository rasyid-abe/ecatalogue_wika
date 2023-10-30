from sqlalchemy import create_engine

import pymysql
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from sklearn.metrics import mean_squared_error
from numpy import fft

sqlEngine = create_engine('mysql+pymysql://root:@localhost', pool_recycle=3600)

dbConnection = sqlEngine.connect()

frame = pd.read_sql("select * from scmwikac_ecatalog.forecast_new", dbConnection);

pd.set_option('display.expand_frame_repr', False)

dbConnection.close()

harga_besi = np.array(frame['harga_besi'])
harga_billet = np.array(frame['price_billet'])
kurs_bi = np.array(frame['kurs_bi'])


def fourierExtrapolation(x, n_predict):
    n = x.size
    n_harm = 30  # number of harmonics in model
    t = np.arange(0, n)
    p = np.polyfit(t, x, 12)  # find linear trend in x
    x_notrend = x - p[0] * t  # detrended x
    x_freqdom = fft.fft(x_notrend)  # detrended x in frequency domain
    f = fft.fftfreq(n)  # frequencies
    indexes = list(range(n))
    # sort indexes by frequency, lower -> higher
    indexes.sort(key=lambda i: np.absolute(f[i]))

    t = np.arange(0, n + n_predict)
    restored_sig = np.zeros(t.size)
    for i in indexes[:1 + n_harm * 2]:
        ampli = np.absolute(x_freqdom[i]) / n  # amplitude
        phase = np.angle(x_freqdom[i])  # phase
        restored_sig += ampli * np.cos(2 * np.pi * f[i] * t + phase)
    return restored_sig + p[0] * t


n_predict = 30
extrapolation = fourierExtrapolation(harga_besi, n_predict)
plt.figure(figsize=(10, 5))
plt.plot(np.arange(0, extrapolation.size), extrapolation, 'r', label='prediction')
plt.plot(np.arange(0, harga_besi.size), harga_besi, 'b', label='data')
plt.legend()
plt.savefig('C:/xampp/htdocs/cek/my_plot.png')
